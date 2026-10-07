<?php

namespace JeffersonGoncalves\FilamentMailEditor\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JeffersonGoncalves\MailEditor\Enums\BlockCategory;
use JeffersonGoncalves\MailEditor\Enums\TemplateCategory;
use JeffersonGoncalves\MailEditor\Enums\TemplateStatus;
use JeffersonGoncalves\MailEditor\Events\TemplateExported;
use JeffersonGoncalves\MailEditor\Events\TestEmailSent;
use JeffersonGoncalves\MailEditor\Jobs\CheckLinksJob;
use JeffersonGoncalves\MailEditor\Models\EmailBrandKit;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;
use JeffersonGoncalves\MailEditor\Models\EmailTemplateVersion;
use JeffersonGoncalves\MailEditor\Models\EmailTheme;
use JeffersonGoncalves\MailEditor\Models\SavedEmailBlock;
use JeffersonGoncalves\MailEditor\Support\AccessibilityChecker;
use JeffersonGoncalves\MailEditor\Support\BlockRegistry;
use JeffersonGoncalves\MailEditor\Support\HtmlExporter;
use JeffersonGoncalves\MailEditor\Support\LinkChecker;
use JeffersonGoncalves\MailEditor\Support\PlaintextGenerator;
use JeffersonGoncalves\MailEditor\Support\QualityChecker;
use JeffersonGoncalves\MailEditor\Support\SpamScoreAnalyzer;
use JeffersonGoncalves\MailEditor\Support\TemplateImportExport;
use JeffersonGoncalves\MailEditor\Support\ThemeApplier;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmailBuilder extends Component
{
    use WithFileUploads;

    public ?int $templateId = null;

    public string $name = '';

    public string $subject = '';

    public string $preheader = '';

    public string $category = 'transactional';

    public array $blocks = [];

    public array $settings = [];

    public string $previewClient = 'gmail';

    /** @var TemporaryUploadedFile|null */
    public $uploadedImage = null;

    public string $testEmailAddress = '';

    public array $testVariables = [];

    public bool $previewWithVariables = false;

    public string $activeTheme = 'default';

    public bool $isLocked = false;

    public string $lockedByName = '';

    public string $templateStatus = 'draft';

    /** @var list<array{label: string, status: string, message: string}> */
    public array $qualityResults = [];

    public bool $qualityModalOpen = false;

    public function mount(?int $templateId = null): void
    {
        $this->settings = config('mail-editor.default_settings', []);

        if ($templateId) {
            $this->templateId = $templateId;
            $model = config('mail-editor.model', EmailTemplate::class);
            $template = $model::findOrFail($templateId);
            $this->name = $template->name;
            $this->subject = $template->subject;
            $this->preheader = $template->preheader ?? '';
            $this->category = $template->category instanceof TemplateCategory
                ? $template->category->value
                : ($template->category ?? 'transactional');
            $this->blocks = $template->blocks ?? [];
            $this->settings = array_merge($this->settings, $template->settings ?? []);
            $this->activeTheme = $this->settings['theme_slug'] ?? 'default';
            $this->templateStatus = $template->status instanceof TemplateStatus
                ? $template->status->value
                : ($template->status ?? 'draft');

            // Check lock status
            if ($template->isLockedByOther()) {
                $this->isLocked = true;
                $this->lockedByName = $template->locked_by ?? '';
            } else {
                // Lock for current user
                $template->lock();
            }
        }

        $this->detectVariables();
    }

    public function syncBlocks(array $blocks): void
    {
        $this->blocks = $blocks;
        $this->detectVariables();
    }

    public function updateBlockProps(string $blockId, array $props): void
    {
        foreach ($this->blocks as &$block) {
            if (($block['id'] ?? '') === $blockId) {
                $block['props'] = array_merge($block['props'] ?? [], $props);

                break;
            }
        }
        unset($block);

        $this->detectVariables();
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
        ]);

        $model = config('mail-editor.model', EmailTemplate::class);

        // Create version snapshot before updating existing template
        if ($this->templateId) {
            $existing = $model::find($this->templateId);
            if ($existing && $existing->blocks) {
                $existing->createVersion(
                    reason: 'Auto-save before edit',
                    createdBy: $this->resolveCurrentUserName(),
                );
            }
        }

        $template = $model::updateOrCreate(
            ['id' => $this->templateId],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'subject' => $this->subject,
                'preheader' => $this->preheader,
                'category' => $this->category,
                'blocks' => $this->blocks,
                'settings' => $this->settings,
            ]
        );

        $this->templateId = $template->id;
        $this->dispatch('template-saved', id: $template->id);

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.template_saved'))
            ->success()
            ->send();
    }

    public function export(): StreamedResponse
    {
        $html = app(HtmlExporter::class)->export($this->blocks, $this->settings);

        if ($this->templateId) {
            $model = config('mail-editor.model', EmailTemplate::class);
            $template = $model::find($this->templateId);
            if ($template) {
                TemplateExported::dispatch($template, 'html');
            }
        }

        return response()->streamDownload(
            fn () => print ($html),
            Str::slug($this->name ?: 'email-template').'.html',
            ['Content-Type' => 'text/html']
        );
    }

    public function exportPlaintext(): StreamedResponse
    {
        $plaintext = (new PlaintextGenerator)->generate($this->blocks);

        return response()->streamDownload(
            fn () => print ($plaintext),
            Str::slug($this->name ?: 'email-template').'.txt',
            ['Content-Type' => 'text/plain']
        );
    }

    /**
     * Export the current template as a JSON file for portability.
     */
    public function exportJson(): StreamedResponse
    {
        $model = config('mail-editor.model', EmailTemplate::class);
        $template = new $model;
        $template->name = $this->name;
        $template->subject = $this->subject;
        $template->preheader = $this->preheader;
        $template->category = $this->category;
        $template->blocks = $this->blocks;
        $template->settings = $this->settings;

        $json = (new TemplateImportExport)->exportJson($template);

        return response()->streamDownload(
            fn () => print ($json),
            Str::slug($this->name ?: 'email-template').'.json',
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Import a template from an uploaded JSON file.
     */
    public function importJson(string $jsonContent): void
    {
        try {
            $importer = new TemplateImportExport;
            $template = $importer->importJson($jsonContent);

            // Load the imported template into the builder
            $this->templateId = $template->id;
            $this->name = $template->name;
            $this->subject = $template->subject;
            $this->preheader = $template->preheader ?? '';
            $this->category = $template->category instanceof TemplateCategory
                ? $template->category->value
                : ($template->category ?? 'transactional');
            $this->blocks = $template->blocks ?? [];
            $this->settings = array_merge($this->settings, $template->settings ?? []);
            $this->detectVariables();

            $this->dispatch('template-imported', id: $template->id);

            Notification::make()
                ->title(__('filament-mail-editor::filament-mail-editor.notifications.template_imported'))
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title(__('filament-mail-editor::filament-mail-editor.notifications.import_failed'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /** @return array{url: string, filename: string} */
    public function uploadImage(): array
    {
        $this->validate(['uploadedImage' => 'image|max:2048']);

        $disk = config('mail-editor.storage_disk', 'public');
        $path = config('mail-editor.storage_path', 'email-images');

        $storedPath = $this->uploadedImage->store($path, $disk);

        $url = Storage::disk($disk)->url($storedPath);

        $result = [
            'url' => $url,
            'filename' => $this->uploadedImage->getClientOriginalName(),
        ];

        $this->reset('uploadedImage');

        return $result;
    }

    public function sendTestEmail(): void
    {
        $this->validate(['testEmailAddress' => 'required|email']);

        $html = app(HtmlExporter::class)->export($this->blocks, $this->settings);

        if ($this->previewWithVariables && ! empty($this->testVariables)) {
            foreach ($this->testVariables as $var => $replacement) {
                $html = str_replace('{{'.$var.'}}', (string) $replacement, $html);
            }
        }

        $address = $this->testEmailAddress;
        $emailSubject = '[TEST] '.($this->subject ?: 'Email Template');

        Mail::html($html, function ($message) use ($address, $emailSubject) {
            $message->to($address)->subject($emailSubject);
        });

        if ($this->templateId) {
            $model = config('mail-editor.model', EmailTemplate::class);
            $template = $model::find($this->templateId);
            if ($template) {
                TestEmailSent::dispatch($template, $address);
            }
        }

        $this->dispatch('test-email-sent');

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.test_email_sent', ['address' => $address]))
            ->success()
            ->send();
    }

    /** @return list<string> */
    public function getExportWarnings(): array
    {
        return app(HtmlExporter::class)->validate($this->blocks);
    }

    public function runQualityCheck(): void
    {
        $template = new EmailTemplate;
        $template->blocks = $this->blocks;
        $template->subject = $this->subject;

        $this->qualityResults = (new QualityChecker)->check($template);
        $this->qualityModalOpen = true;

        $counts = array_count_values(array_column($this->qualityResults, 'status'));
        $errors = $counts['error'] ?? 0;
        $warnings = $counts['warning'] ?? 0;
        $ok = $counts['ok'] ?? 0;

        $notification = Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.quality_check_summary'))
            ->body(__('filament-mail-editor::filament-mail-editor.notifications.quality_check_body', [
                'ok' => $ok,
                'warnings' => $warnings,
                'errors' => $errors,
            ]));

        match (true) {
            $errors > 0 => $notification->danger(),
            $warnings > 0 => $notification->warning(),
            default => $notification->success(),
        };

        $notification->send();
    }

    public function closeQualityModal(): void
    {
        $this->qualityModalOpen = false;
    }

    /**
     * Run accessibility checks on the current template.
     *
     * @return list<array{label: string, status: string, message: string, wcag: string}>
     */
    public function runAccessibilityCheck(): array
    {
        return (new AccessibilityChecker)->check($this->blocks);
    }

    /**
     * Check all links in the template. Uses async job for 3+ URLs, sync for fewer.
     *
     * @return array{status: string, results: list<array{url: string, status: string, message: string, block_type: string}>}
     */
    public function checkLinks(): array
    {
        $checker = new LinkChecker;
        $urls = $checker->extractUrls($this->blocks);

        if (count($urls) < 3) {
            return ['status' => 'completed', 'results' => $checker->check($this->blocks)];
        }

        $cacheKey = CheckLinksJob::cacheKey($this->templateId ?? 0);
        $cached = Cache::get($cacheKey);

        if ($cached && $cached['status'] === 'completed') {
            Cache::forget($cacheKey);

            return $cached;
        }

        if ($cached && $cached['status'] === 'processing') {
            return ['status' => 'processing', 'results' => []];
        }

        CheckLinksJob::dispatch($cacheKey, $this->blocks);

        return ['status' => 'processing', 'results' => []];
    }

    /**
     * Poll for async link check results.
     *
     * @return array{status: string, results: list<array{url: string, status: string, message: string, block_type: string}>}|null
     */
    public function pollLinkCheck(): ?array
    {
        $cacheKey = CheckLinksJob::cacheKey($this->templateId ?? 0);
        $cached = Cache::get($cacheKey);

        if (! $cached) {
            return null;
        }

        if ($cached['status'] === 'completed') {
            Cache::forget($cacheKey);
        }

        return $cached;
    }

    /**
     * Run a comprehensive spam/deliverability analysis.
     *
     * @return array{score: int, checks: list<array{label: string, status: string, message: string, points: int}>}
     */
    public function runSpamScoreAnalysis(): array
    {
        $template = new EmailTemplate;
        $template->blocks = $this->blocks;
        $template->subject = $this->subject;

        return (new SpamScoreAnalyzer)->analyze($template);
    }

    public function applyTheme(string $themeKey): void
    {
        $themeModel = EmailTheme::where('slug', $themeKey)->first();
        if (! $themeModel) {
            return;
        }

        $theme = $themeModel->toThemeArray();
        $this->activeTheme = $themeKey;
        $this->settings = array_merge($this->settings, $theme, ['theme_slug' => $themeKey]);

        $applier = new ThemeApplier;
        $this->blocks = $applier->apply($this->blocks, $theme);

        $this->dispatch('theme-applied', theme: $themeKey);
    }

    /**
     * Apply a brand kit to the current template.
     */
    public function applyBrandKit(int $brandKitId): void
    {
        $brandKit = EmailBrandKit::find($brandKitId);
        if (! $brandKit) {
            return;
        }

        $theme = $brandKit->toThemeArray();
        $this->settings = array_merge($this->settings, $theme);

        $applier = new ThemeApplier;
        $this->blocks = $applier->apply($this->blocks, $theme);

        // Apply brand kit defaults to header/footer blocks
        foreach ($this->blocks as &$block) {
            if ($block['type'] === 'header' && $brandKit->logo_url) {
                $block['props']['logo_src'] = $brandKit->logo_url;
                $block['props']['logo_alt'] = $brandKit->logo_alt ?? '';
            }

            if ($block['type'] === 'footer') {
                if ($brandKit->footer_address) {
                    $block['props']['address'] = $brandKit->footer_address;
                }
                if ($brandKit->unsubscribe_url) {
                    $block['props']['unsubscribe_url'] = $brandKit->unsubscribe_url;
                }
                if ($brandKit->social_links) {
                    $block['props']['social_links'] = $brandKit->social_links;
                }
            }
        }
        unset($block);

        $this->dispatch('brand-kit-applied', brandKitId: $brandKitId);

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.brand_kit_applied', ['name' => $brandKit->name]))
            ->success()
            ->send();
    }

    /**
     * Get available brand kits.
     *
     * @return \Illuminate\Support\Collection<int, EmailBrandKit>
     */
    public function getBrandKits(): \Illuminate\Support\Collection
    {
        return EmailBrandKit::orderBy('name')->get();
    }

    public function saveBlockAsComponent(string $blockId, string $name, string $description = '', ?string $componentCategory = null): void
    {
        $block = collect($this->blocks)->firstWhere('id', $blockId);
        if (! $block) {
            return;
        }

        $category = BlockCategory::tryFrom($componentCategory ?? '')
            ?? BlockCategory::tryFrom((string) (app(BlockRegistry::class)->find($block['type'])?->category() ?? ''))
            ?? BlockCategory::Content;

        SavedEmailBlock::create([
            'name' => $name,
            'description' => $description,
            'type' => $block['type'],
            'props' => $block['props'],
            'is_global' => true,
            'category' => $category,
        ]);

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.block_saved'))
            ->success()
            ->send();
    }

    /** @return Collection<int, SavedEmailBlock> */
    public function getSavedBlocks(): Collection
    {
        return SavedEmailBlock::orderBy('name')->get();
    }

    public function addSavedBlock(int $savedBlockId): void
    {
        $saved = SavedEmailBlock::find($savedBlockId);
        if (! $saved) {
            return;
        }

        $newBlock = [
            'id' => 'b_'.Str::random(7),
            'type' => $saved->type,
            'props' => $saved->props,
        ];

        $this->blocks[] = $newBlock;
        $this->dispatch('block-added', block: $newBlock);
    }

    /**
     * Submit the current template for review.
     */
    public function submitForReview(): void
    {
        if (! $this->templateId) {
            return;
        }

        $model = config('mail-editor.model', EmailTemplate::class);
        $template = $model::findOrFail($this->templateId);
        $template->submitForReview();
        $this->templateStatus = TemplateStatus::Review->value;

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.template_submitted_for_review'))
            ->success()
            ->send();
    }

    /**
     * Approve the current template.
     */
    public function approveTemplate(): void
    {
        if (! $this->templateId) {
            return;
        }

        $model = config('mail-editor.model', EmailTemplate::class);
        $template = $model::findOrFail($this->templateId);
        $template->approve();
        $this->templateStatus = TemplateStatus::Approved->value;

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.template_approved'))
            ->success()
            ->send();
    }

    /**
     * Reject and send template back to draft.
     */
    public function rejectTemplate(): void
    {
        if (! $this->templateId) {
            return;
        }

        $model = config('mail-editor.model', EmailTemplate::class);
        $template = $model::findOrFail($this->templateId);
        $template->rejectToDraft();
        $this->templateStatus = TemplateStatus::Draft->value;

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.template_returned_to_draft'))
            ->info()
            ->send();
    }

    /**
     * Unlock the template when leaving.
     */
    public function dehydrate(): void
    {
        // Unlock template when component is dehydrated (user leaving page)
        if ($this->templateId && ! $this->isLocked) {
            $model = config('mail-editor.model', EmailTemplate::class);
            $template = $model::find($this->templateId);
            $template?->unlock();
        }
    }

    /**
     * Get version history for the current template.
     *
     * @return \Illuminate\Support\Collection<int, EmailTemplateVersion>
     */
    public function getVersionHistory(): \Illuminate\Support\Collection
    {
        if (! $this->templateId) {
            return collect();
        }

        $model = config('mail-editor.model', EmailTemplate::class);

        return $model::find($this->templateId)
            ?->versions()
            ->orderByDesc('version_number')
            ->limit(50)
            ->get() ?? collect();
    }

    /**
     * Restore template to a specific version.
     */
    public function restoreVersion(int $versionId): void
    {
        if (! $this->templateId) {
            return;
        }

        $model = config('mail-editor.model', EmailTemplate::class);
        $template = $model::findOrFail($this->templateId);

        // Save current state as a version before restoring
        $template->createVersion(
            reason: 'Before restoring to older version',
            createdBy: $this->resolveCurrentUserName(),
        );

        $version = EmailTemplateVersion::where('template_id', $this->templateId)
            ->findOrFail($versionId);

        $this->blocks = $version->blocks;
        $this->settings = array_merge($this->settings, $version->settings ?? []);
        $this->subject = $version->subject;
        $this->preheader = $version->preheader ?? '';

        $template->update([
            'blocks' => $this->blocks,
            'settings' => $this->settings,
            'subject' => $this->subject,
            'preheader' => $this->preheader,
        ]);

        $this->detectVariables();
        $this->dispatch('version-restored', versionId: $versionId);

        Notification::make()
            ->title(__('filament-mail-editor::filament-mail-editor.notifications.version_restored', ['number' => $version->version_number]))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('filament-mail-editor::email-builder', [
            'availableBlocks' => app(BlockRegistry::class)->catalog(),
            'detectedVariables' => HtmlExporter::extractVariables($this->blocks),
            'themes' => EmailTheme::orderBy('name')->pluck('name', 'slug')->toArray(),
            'savedBlocks' => $this->getSavedBlocks(),
        ]);
    }

    protected function resolveCurrentUserName(): ?string
    {
        /** @var (Authenticatable&object{name?: string, email?: string})|null $user */
        $user = auth()->user();

        return $user->name ?? $user->email ?? null;
    }

    protected function detectVariables(): void
    {
        $detected = HtmlExporter::extractVariables($this->blocks);

        foreach ($detected as $var) {
            if (! isset($this->testVariables[$var])) {
                $this->testVariables[$var] = '';
            }
        }

        $this->testVariables = array_intersect_key($this->testVariables, array_flip($detected));
    }
}
