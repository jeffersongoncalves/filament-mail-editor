<?php

use Illuminate\Validation\ValidationException;
use JeffersonGoncalves\FilamentMailEditor\Livewire\EmailBuilder;
use JeffersonGoncalves\FilamentMailEditor\Support\HtmlExporter;

it('generates export warnings when no footer is present', function () {
    $builder = new EmailBuilder;
    $builder->blocks = [
        ['id' => 'b_1', 'type' => 'heading', 'props' => ['text' => 'Test Email']],
    ];

    $warnings = $builder->getExportWarnings();

    expect($warnings)
        ->toContain('No Footer block found. Unsubscribe is required by law (CAN-SPAM/LGPD).')
        ->toContain('No Preheader block found. Recommended to improve open rates.');
});

it('validates email address before sending', function () {
    $builder = new EmailBuilder;
    $builder->testEmailAddress = 'not-an-email';

    expect(fn () => $builder->sendTestEmail())
        ->toThrow(ValidationException::class);
});

it('detects merge variables in blocks', function () {
    $builder = new EmailBuilder;
    $builder->blocks = [
        ['id' => 'b_1', 'type' => 'heading', 'props' => ['text' => 'Hello {{nome}}']],
        ['id' => 'b_2', 'type' => 'paragraph', 'props' => ['html' => 'Company: {{empresa}}']],
    ];

    $builder->syncBlocks($builder->blocks);

    expect($builder->testVariables)
        ->toHaveKeys(['nome', 'empresa']);
});

it('exports HTML with variables replaced in model render', function () {
    $blocks = [
        ['type' => 'heading', 'props' => ['text' => 'Welcome {{nome}}']],
    ];

    $vars = HtmlExporter::extractVariables($blocks);
    expect($vars)->toContain('nome');
});
