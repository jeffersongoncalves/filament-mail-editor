<?php

use JeffersonGoncalves\FilamentMailEditor\Livewire\EmailBuilder;
use JeffersonGoncalves\FilamentMailEditor\Models\SavedEmailBlock;

it('saves a block as component via builder', function () {
    $builder = new EmailBuilder;
    $builder->blocks = [
        ['id' => 'b_test', 'type' => 'button', 'props' => ['text' => 'CTA', 'url' => 'https://example.com', 'bg_color' => '#FF0000']],
    ];

    $builder->saveBlockAsComponent('b_test', 'Red CTA Button', 'A red call-to-action button', 'cta');

    $saved = SavedEmailBlock::first();
    expect($saved)->not->toBeNull();
    expect($saved->name)->toBe('Red CTA Button');
    expect($saved->type)->toBe('button');
    expect($saved->props['bg_color'])->toBe('#FF0000');
    expect($saved->is_global)->toBeTrue();
});

it('adds a saved block back to the builder', function () {
    $saved = SavedEmailBlock::create([
        'name' => 'Test Component',
        'type' => 'heading',
        'props' => ['text' => 'Saved Heading', 'color' => '#333'],
        'is_global' => true,
        'category' => 'heading',
    ]);

    $builder = new EmailBuilder;
    $builder->blocks = [];
    $builder->addSavedBlock($saved->id);

    expect($builder->blocks)->toHaveCount(1);
    expect($builder->blocks[0]['type'])->toBe('heading');
    expect($builder->blocks[0]['props']['text'])->toBe('Saved Heading');
    expect($builder->blocks[0]['id'])->toStartWith('b_');
});

it('retrieves all saved blocks', function () {
    SavedEmailBlock::create(['name' => 'Block A', 'type' => 'button', 'props' => ['text' => 'A'], 'is_global' => true]);
    SavedEmailBlock::create(['name' => 'Block B', 'type' => 'heading', 'props' => ['text' => 'B'], 'is_global' => true]);

    $builder = new EmailBuilder;
    $saved = $builder->getSavedBlocks();

    expect($saved)->toHaveCount(2);
});
