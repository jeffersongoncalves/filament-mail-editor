<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use JeffersonGoncalves\FilamentMailEditor\Livewire\EmailBuilder;

it('uploads an image and returns url', function () {
    Storage::fake('public');

    $builder = new EmailBuilder;
    $builder->uploadedImage = UploadedFile::fake()->image('banner.jpg', 600, 300);

    $result = $builder->uploadImage();

    expect($result)
        ->toHaveKeys(['url', 'filename'])
        ->and($result['filename'])->toBe('banner.jpg');

    Storage::disk('public')->assertExists('email-images/'.$builder->uploadedImage);
})->skip('Livewire file upload requires full component lifecycle');

it('validates image upload size', function () {
    $builder = new EmailBuilder;
    $builder->uploadedImage = UploadedFile::fake()->create('huge.jpg', 3000); // 3MB

    expect(fn () => $builder->uploadImage())->toThrow(ValidationException::class);
})->skip('Livewire validation requires full component lifecycle');
