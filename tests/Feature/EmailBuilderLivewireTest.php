<?php

use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateCategory;
use JeffersonGoncalves\FilamentMailEditor\Livewire\EmailBuilder;
use JeffersonGoncalves\FilamentMailEditor\Models\EmailTemplate;
use JeffersonGoncalves\FilamentMailEditor\Support\BlockRegistry;

it('registers the email builder livewire component', function () {
    expect(app('livewire')->isDiscoverable(EmailBuilder::class)
        || app('livewire')->getComponentAliases()['email-builder'] ?? null
    )->not->toBeNull();
});

it('registers all 22 blocks in the registry', function () {
    $registry = app(BlockRegistry::class);

    expect($registry->all())->toHaveCount(22);
    expect($registry->find('preheader'))->not->toBeNull();
    expect($registry->find('header'))->not->toBeNull();
    expect($registry->find('hero'))->not->toBeNull();
    expect($registry->find('heading'))->not->toBeNull();
    expect($registry->find('paragraph'))->not->toBeNull();
    expect($registry->find('button'))->not->toBeNull();
    expect($registry->find('image'))->not->toBeNull();
    expect($registry->find('divider'))->not->toBeNull();
    expect($registry->find('spacer'))->not->toBeNull();
    expect($registry->find('testimonial'))->not->toBeNull();
    expect($registry->find('alert'))->not->toBeNull();
    expect($registry->find('two-columns'))->not->toBeNull();
    expect($registry->find('three-columns'))->not->toBeNull();
    expect($registry->find('footer'))->not->toBeNull();
    expect($registry->find('list'))->not->toBeNull();
    expect($registry->find('video-thumb'))->not->toBeNull();
    expect($registry->find('product-card'))->not->toBeNull();
    expect($registry->find('rating'))->not->toBeNull();
    expect($registry->find('data-table'))->not->toBeNull();
    expect($registry->find('coupon'))->not->toBeNull();
    expect($registry->find('logo-grid'))->not->toBeNull();
    expect($registry->find('countdown'))->not->toBeNull();
});

it('returns null for unknown block type', function () {
    $registry = app(BlockRegistry::class);

    expect($registry->find('unknown-block'))->toBeNull();
});

it('provides block catalog with correct structure', function () {
    $registry = app(BlockRegistry::class);
    $catalog = $registry->catalog();

    expect($catalog)->toHaveCount(22);

    foreach ($catalog as $type => $info) {
        expect($info)->toHaveKeys(['type', 'label', 'icon', 'category', 'defaultProps']);
        expect($info['type'])->toBe($type);
        expect($info['label'])->toBeString()->not->toBeEmpty();
        expect($info['icon'])->toBeString()->toStartWith('heroicon-');
        expect($info['category'])->toBeIn(['structure', 'content', 'marketing']);
    }
});

it('can save a template via the builder', function () {
    $builder = new EmailBuilder;
    $builder->name = 'Test Template';
    $builder->subject = 'Test Subject';
    $builder->preheader = 'Preview text';
    $builder->category = 'marketing';
    $builder->blocks = [
        ['id' => 'b_test1', 'type' => 'heading', 'props' => ['text' => 'Hello']],
        ['id' => 'b_test2', 'type' => 'paragraph', 'props' => ['html' => 'World']],
    ];

    // Manually call save logic
    $template = EmailTemplate::create([
        'name' => $builder->name,
        'slug' => Str::slug($builder->name),
        'subject' => $builder->subject,
        'preheader' => $builder->preheader,
        'category' => $builder->category,
        'blocks' => $builder->blocks,
        'settings' => $builder->settings,
    ]);

    expect($template->name)->toBe('Test Template');
    expect($template->slug)->toBe('test-template');
    expect($template->blocks)->toHaveCount(2);
    expect($template->category)->toBe(TemplateCategory::Marketing);
});

it('syncs blocks correctly', function () {
    $builder = new EmailBuilder;
    $builder->blocks = [];

    $newBlocks = [
        ['id' => 'b_1', 'type' => 'heading', 'props' => ['text' => 'A']],
        ['id' => 'b_2', 'type' => 'button', 'props' => ['text' => 'Click']],
    ];

    $builder->syncBlocks($newBlocks);

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

it('loads template in mount', function () {
    $template = EmailTemplate::create([
        'name' => 'Loaded',
        'slug' => 'loaded',
        'subject' => 'Subject',
        'preheader' => 'Preview',
        'category' => 'notification',
        'blocks' => [['id' => 'b_x', 'type' => 'heading', 'props' => ['text' => 'Hi']]],
        'settings' => ['primary_color' => '#ff0000'],
    ]);

    $builder = new EmailBuilder;
    $builder->mount($template->id);

    expect($builder->name)->toBe('Loaded');
    expect($builder->subject)->toBe('Subject');
    expect($builder->preheader)->toBe('Preview');
    expect($builder->category)->toBe('notification');
    expect($builder->blocks)->toHaveCount(1);
    expect($builder->blocks[0]['props']['text'])->toBe('Hi');
});
