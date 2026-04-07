<?php

namespace JeffersonGoncalves\FilamentMailEditor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;
use JeffersonGoncalves\FilamentMailEditor\Support\HtmlExporter;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmailBuilder extends Component
{
    public ?int $templateId = null;

    public string $name = '';

    public string $subject = '';

    public string $preheader = '';

    public string $category = 'transactional';

    public array $blocks = [];

    public array $settings = [];

    public string $previewClient = 'gmail';

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
    }

    public function syncBlocks(array $blocks): void
    {
        $this->blocks = $blocks;
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

    public function render(): View
    {
        return view('filament-mail-editor::email-builder', [
            'availableBlocks' => app(BlockRegistry::class)->catalog(),
        ]);
    }
}
