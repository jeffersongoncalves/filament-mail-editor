<?php

namespace JeffersonGoncalves\FilamentMailEditor\Support;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;

class TemplateMailableBridge extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected string $renderedHtml = '';

    protected string $renderedPlaintext = '';

    /**
     * @param  array<string, mixed>  $variables
     */
    public function __construct(
        protected string $slug,
        protected array $variables = [],
    ) {}

    public function envelope(): Envelope
    {
        $template = $this->resolveTemplate();

        return new Envelope(
            subject: $template->subject ?? $this->slug,
        );
    }

    public function content(): Content
    {
        $this->buildContent();

        return new Content(
            htmlString: $this->renderedHtml,
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build(): static
    {
        $this->buildContent();

        return $this->html($this->renderedHtml)
            ->text('filament-mail-editor::plaintext', ['content' => $this->renderedPlaintext]);
    }

    protected function buildContent(): void
    {
        if ($this->renderedHtml !== '') {
            return;
        }

        $template = $this->resolveTemplate();
        $this->renderedHtml = $template->render($this->variables);

        $generator = new PlaintextGenerator;
        $blocks = $template->blocks ?? [];
        $blocks = array_map(function (array $block) {
            $block['props'] = $this->replaceVariablesInProps($block['props']);

            return $block;
        }, $blocks);
        $this->renderedPlaintext = $generator->generate($blocks);
    }

    protected function resolveTemplate(): EmailTemplate
    {
        $model = config('filament-mail-editor.model', EmailTemplate::class);

        return $model::where('slug', $this->slug)->firstOrFail();
    }

    /**
     * @param  array<string, mixed>  $props
     * @return array<string, mixed>
     */
    protected function replaceVariablesInProps(array $props): array
    {
        foreach ($props as $key => $value) {
            if (is_string($value)) {
                foreach ($this->variables as $var => $replacement) {
                    $value = str_replace('{{'.$var.'}}', (string) $replacement, $value);
                }
                $props[$key] = $value;
            } elseif (is_array($value)) {
                $props[$key] = $this->replaceVariablesInProps($value);
            }
        }

        return $props;
    }
}
