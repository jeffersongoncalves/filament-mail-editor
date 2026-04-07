<?php

namespace JeffersonGoncalves\FilamentMailEditor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Models\SavedEmailBlock;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;
use JeffersonGoncalves\FilamentMailEditor\Support\HtmlExporter;
use JeffersonGoncalves\FilamentMailEditor\Support\PlaintextGenerator;
use JeffersonGoncalves\FilamentMailEditor\Support\QualityChecker;
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

    public function render(): View
    {
        return view('filament-mail-editor::email-builder', [
            'availableBlocks' => app(BlockRegistry::class)->catalog(),
            'detectedVariables' => HtmlExporter::extractVariables($this->blocks),
            'themes' => array_keys(config('filament-mail-editor.themes', [])),
            'savedBlocks' => $this->getSavedBlocks(),
        ]);
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
