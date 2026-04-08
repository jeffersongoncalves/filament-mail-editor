<?php

namespace JeffersonGoncalves\FilamentMailEditor\Livewire;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailBrandKit;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplateVersion;
use JeffersonGoncalves\FilamentMailEditor\Models\SavedEmailBlock;
use JeffersonGoncalves\FilamentMailEditor\Support\AccessibilityChecker;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;
use JeffersonGoncalves\FilamentMailEditor\Support\HtmlExporter;
use JeffersonGoncalves\FilamentMailEditor\Support\LinkChecker;
use JeffersonGoncalves\FilamentMailEditor\Support\PlaintextGenerator;
use JeffersonGoncalves\FilamentMailEditor\Support\QualityChecker;
use JeffersonGoncalves\FilamentMailEditor\Support\SpamScoreAnalyzer;
use JeffersonGoncalves\FilamentMailEditor\Support\TemplateImportExport;
use JeffersonGoncalves\FilamentMailEditor\Support\ThemeApplier;
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

    public function mount(?int $templateId = null): void
    {
        $this->settings = config('filament-mail-editor.default_settings', []);

        if ($templateId) {
            $this->templateId = $templateId;
            $model = config('filament-mail-editor.model', EmailTemplate::class);
            $template = $model::findOrFail($templateId);
            $this->name = $template->name;
            $this->subject = $template->subject;
            $this->preheader = $template->preheader ?? '';
            $this->category = $template->category ?? 'transactional';
            $this->blocks = $template->blocks ?? [];
            $this->settings = array_merge($this->settings, $template->settings ?? []);
            $this->templateStatus = $template->status ?? 'draft';

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

        $model = config('filament-mail-editor.model', EmailTemplate::class);

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
        $this->dispatch('notify', type: 'success', message: 'Template saved successfully.');
    }

    public function export(): StreamedResponse
    {
        $html = app(HtmlExporter::class)->export($this->blocks, $this->settings);

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
        $model = config('filament-mail-editor.model', EmailTemplate::class);
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
            $this->category = $template->category ?? 'transactional';
            $this->blocks = $template->blocks ?? [];
            $this->settings = array_merge($this->settings, $template->settings ?? []);
            $this->detectVariables();

            $this->dispatch('template-imported', id: $template->id);
            $this->dispatch('notify', type: 'success', message: 'Template imported successfully.');
        } catch (\Throwable $e) {
            $this->dispatch('notify', type: 'error', message: 'Import failed: '.$e->getMessage());
        }
    }

    /** @return array{url: string, filename: string} */
    public function uploadImage(): array
    {
        $this->validate(['uploadedImage' => 'image|max:2048']);

        $disk = config('filament-mail-editor.storage_disk', 'public');
        $path = config('filament-mail-editor.storage_path', 'email-images');

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

        $this->dispatch('test-email-sent');
        $this->dispatch('notify', type: 'success', message: 'Test email sent to '.$address);
    }

    /** @return list<string> */
    public function getExportWarnings(): array
    {
        return app(HtmlExporter::class)->validate($this->blocks);
    }

    /**
     * @return list<array{label: string, status: string, message: string}>
     */
    public function runQualityCheck(): array
    {
        $template = new EmailTemplate;
        $template->blocks = $this->blocks;
        $template->subject = $this->subject;

        return (new QualityChecker)->check($template);
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
     * Check all links in the template for broken URLs.
     *
     * @return list<array{url: string, status: string, message: string, block_type: string}>
     */
    public function checkLinks(): array
    {
        return (new LinkChecker)->check($this->blocks);
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
        $theme = config("filament-mail-editor.themes.{$themeKey}");
        if (! $theme) {
            return;
        }

        $this->activeTheme = $themeKey;
        $this->settings = array_merge($this->settings, $theme);

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
        $this->dispatch('notify', type: 'success', message: 'Brand kit "'.$brandKit->name.'" applied.');
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

    public function saveBlockAsComponent(string $blockId, string $name, string $description = '', string $componentCategory = ''): void
    {
        $block = collect($this->blocks)->firstWhere('id', $blockId);
        if (! $block) {
            return;
        }

        SavedEmailBlock::create([
            'name' => $name,
            'description' => $description,
            'type' => $block['type'],
            'props' => $block['props'],
            'is_global' => true,
            'category' => $componentCategory ?: $block['type'],
        ]);

        $this->dispatch('notify', type: 'success', message: 'Block saved to library.');
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

        $model = config('filament-mail-editor.model', EmailTemplate::class);
        $template = $model::findOrFail($this->templateId);
        $template->submitForReview();
        $this->templateStatus = EmailTemplate::STATUS_REVIEW;

        $this->dispatch('notify', type: 'success', message: 'Template submitted for review.');
    }

    /**
     * Approve the current template.
     */
    public function approveTemplate(): void
    {
        if (! $this->templateId) {
            return;
        }

        $model = config('filament-mail-editor.model', EmailTemplate::class);
        $template = $model::findOrFail($this->templateId);
        $template->approve();
        $this->templateStatus = EmailTemplate::STATUS_APPROVED;

        $this->dispatch('notify', type: 'success', message: 'Template approved.');
    }

    /**
     * Reject and send template back to draft.
     */
    public function rejectTemplate(): void
    {
        if (! $this->templateId) {
            return;
        }

        $model = config('filament-mail-editor.model', EmailTemplate::class);
        $template = $model::findOrFail($this->templateId);
        $template->rejectToDraft();
        $this->templateStatus = EmailTemplate::STATUS_DRAFT;

        $this->dispatch('notify', type: 'info', message: 'Template returned to draft.');
    }

    /**
     * Unlock the template when leaving.
     */
    public function dehydrate(): void
    {
        // Unlock template when component is dehydrated (user leaving page)
        if ($this->templateId && ! $this->isLocked) {
            $model = config('filament-mail-editor.model', EmailTemplate::class);
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

        $model = config('filament-mail-editor.model', EmailTemplate::class);

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

        $model = config('filament-mail-editor.model', EmailTemplate::class);
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
        $this->dispatch('notify', type: 'success', message: 'Template restored to version #'.$version->version_number);
    }

    public function render(): View
    {
        return view('filament-mail-editor::email-builder', [
            'availableBlocks' => app(BlockRegistry::class)->catalog(),
            'detectedVariables' => HtmlExporter::extractVariables($this->blocks),
            'themes' => array_keys(config('filament-mail-editor.themes', [])),
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
