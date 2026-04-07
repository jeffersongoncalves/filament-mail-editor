<?php

namespace JeffersonGoncalves\FilamentMailEditor\Support;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class HtmlExporter
{
    public function export(array $blocks, array $settings = []): string
    {
        $blocksHtml = collect($blocks)->map(function ($block) {
            $instance = app(BlockRegistry::class)->find($block['type'] ?? '');

            return $instance?->render($block['props'] ?? []) ?? '';
        })->join("\n");

        $html = view('filament-mail-editor::email-wrapper', [
            'content' => $blocksHtml,
            'settings' => $settings,
        ])->render();

        return (new CssToInlineStyles)->convert($html);
    }
}
