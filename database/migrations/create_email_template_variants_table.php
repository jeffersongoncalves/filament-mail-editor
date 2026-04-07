<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_template_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')
                ->constrained(config('filament-mail-editor.table_name', 'email_templates'))
                ->cascadeOnDelete();
            $table->string('name');
            $table->json('blocks');
            $table->json('settings')->nullable();
            $table->unsignedTinyInteger('send_percentage')->default(50);
            $table->boolean('is_winner')->default(false);
            $table->timestamps();

            $table->index('template_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_template_variants');
    }
};
