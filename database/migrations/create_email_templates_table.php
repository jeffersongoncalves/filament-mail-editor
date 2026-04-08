<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('filament-mail-editor.table_name', 'email_templates'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subject');
            $table->text('preheader')->nullable();
            $table->json('blocks');
            $table->json('settings')->nullable();
            $table->string('category')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('email_template_categories')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('draft');
            $table->string('locked_by')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('filament-mail-editor.table_name', 'email_templates'));
    }
};
