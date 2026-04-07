<?php

namespace JeffersonGoncalves\FilamentMailEditor\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\FilamentMailEditor\Support\HtmlExporter;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $subject
 * @property string|null $preheader
 * @property array<int, array{id: string, type: string, props: array<string, mixed>}> $blocks
 * @property array<string, mixed>|null $settings
 * @property string|null $category
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @method static Builder<static> active()
 *
 * @property-read Collection<int, EmailTemplateVariant> $variants
 */
class EmailTemplate extends Model
{
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'subject',
        'preheader',
        'blocks',
        'settings',
        'category',
        'is_active',
    ];

    protected $casts = [
        'blocks' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function getTable(): string
    {
        return config('filament-mail-editor.table_name', 'email_templates');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** @return HasMany<EmailTemplateVariant, $this> */
    public function variants(): HasMany
    {
        return $this->hasMany(EmailTemplateVariant::class, 'template_id');
    }

    public function render(array $variables = []): string
    {
        $blocks = $this->blocks ?? [];

        $blocks = array_map(function (array $block) use ($variables) {
            $block['props'] = $this->replaceVariables($block['props'], $variables);

            return $block;
        }, $blocks);

        return app(HtmlExporter::class)->export($blocks, $this->settings ?? []);
    }

    protected function replaceVariables(array $props, array $variables): array
    {
        foreach ($props as $key => $value) {
            if (is_string($value)) {
                foreach ($variables as $var => $replacement) {
                    $value = str_replace("{{{$var}}}", (string) $replacement, $value);
                }
                $props[$key] = $value;
            } elseif (is_array($value)) {
                $props[$key] = $this->replaceVariables($value, $variables);
            }
        }

        return $props;
    }
}
