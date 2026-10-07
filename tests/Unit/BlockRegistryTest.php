<?php

use JeffersonGoncalves\FilamentMailEditor\Blocks\Contracts\HasPropsSchema;
use JeffersonGoncalves\FilamentMailEditor\FilamentMailEditorServiceProvider;
use JeffersonGoncalves\MailEditor\MailEditorServiceProvider;
use JeffersonGoncalves\MailEditor\Support\BlockRegistry;

it('layers a Filament form over every block of laravel-mail-editor', function () {
    $blocks = app(BlockRegistry::class)->all();

    expect($blocks)->toHaveCount(count(MailEditorServiceProvider::BLOCKS))
        ->and(array_map(fn ($block) => $block::class, array_values($blocks)))
        ->toEqualCanonicalizing(FilamentMailEditorServiceProvider::BLOCKS);

    foreach ($blocks as $type => $block) {
        expect($block)->toBeInstanceOf(HasPropsSchema::class)
            ->and($block::propsSchema())->not->toBeEmpty()
            ->and($block->render($block::defaultProps()))->toBeString();
    }
});
