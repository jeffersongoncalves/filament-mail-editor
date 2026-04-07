<?php

namespace JeffersonGoncalves\FilamentMailEditor\Support;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class HtmlExporter
{
    public function __construct(
        protected BlockRegistry $registry,
    ) {}

    public function export(array $blocks, array $settings = []): string
    {
        $mediaQueries = collect($blocks)
            ->map(fn (array $b) => $this->registry->find($b['type'] ?? '')?->getMediaQueries())
            ->filter()
            ->unique()
            ->join("\n");

        $blocksHtml = collect($blocks)
            ->map(function (array $block) {
                $instance = $this->registry->find($block['type'] ?? '');

                return $instance?->render($block['props'] ?? []) ?? '';
            })
            ->join("\n");

        $html = view('filament-mail-editor::email-wrapper', [
            'content' => $blocksHtml,
            'settings' => $settings,
            'mediaQueries' => $mediaQueries,
        ])->render();

        return (new CssToInlineStyles)->convert($html);
    }

    /** @return list<string> */
    public static function extractVariables(array $blocks): array
    {
        $html = collect($blocks)->map(fn (array $b) => json_encode($b['props'] ?? []))->join(' ');
        preg_match_all('/\{\{(\w+)\}\}/', $html, $matches);

        return array_values(array_unique($matches[1]));
    }

    /** @return list<string> */
    public function validate(array $blocks): array
    {
        $warnings = [];

        $hasFooter = collect($blocks)->contains(fn (array $b) => ($b['type'] ?? '') === 'footer');
        if (! $hasFooter) {
            $warnings[] = 'No Footer block found. Unsubscribe is required by law (CAN-SPAM/LGPD).';
        }

        $hasPreheader = collect($blocks)->contains(fn (array $b) => ($b['type'] ?? '') === 'preheader');
        if (! $hasPreheader) {
            $warnings[] = 'No Preheader block found. Recommended to improve open rates.';
        }

        collect($blocks)
            ->filter(fn (array $b) => ($b['type'] ?? '') === 'image')
            ->each(function (array $b) use (&$warnings) {
                if (empty($b['props']['alt'])) {
                    $warnings[] = 'Image without alt text. Required for accessibility.';
                }
            });

        $estimatedSize = strlen(json_encode($blocks)) * 1.5;
        if ($estimatedSize > 102400) {
            $warnings[] = 'Template may exceed 100KB. Some clients clip larger emails.';
        }

        return $warnings;
    }
}
