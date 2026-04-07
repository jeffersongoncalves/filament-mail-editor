<?php

use JeffersonGoncalves\FilamentMailEditor\Livewire\EmailBuilder;

it('syncs blocks to the builder', function () {
    $builder = new EmailBuilder;
    $builder->blocks = [];

    $builder->syncBlocks([
        ['id' => 'b_1', 'type' => 'heading', 'props' => ['text' => 'Hello']],
        ['id' => 'b_2', 'type' => 'button', 'props' => ['text' => 'Click']],
    ]);

    expect($builder->blocks)->toHaveCount(2);
    expect($builder->blocks[0]['type'])->toBe('heading');
    expect($builder->blocks[1]['type'])->toBe('button');
});

it('updates block props correctly', function () {
    $builder = new EmailBuilder;
    $builder->blocks = [
        ['id' => 'b_1', 'type' => 'heading', 'props' => ['text' => 'Old', 'color' => '#000']],
    ];

    $builder->updateBlockProps('b_1', ['text' => 'New']);

    expect($builder->blocks[0]['props']['text'])->toBe('New');
    expect($builder->blocks[0]['props']['color'])->toBe('#000');
});
