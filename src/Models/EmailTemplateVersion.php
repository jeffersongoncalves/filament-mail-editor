<?php

namespace JeffersonGoncalves\FilamentMailEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $template_id
 * @property int $version_number
 * @property array<int, array{id: string, type: string, props: array<string, mixed>}> $blocks
 * @property array<string, mixed>|null $settings
 * @property string $subject
 * @property string|null $preheader
 * @property string|null $reason
 * @property string|null $created_by
 * @property Carbon $created_at
 * @property-read EmailTemplate $template
 */
class EmailTemplateVersion extends Model
{
    public $timestamps = false;

    /** @var list<string> */
    protected $fillable = [
        'template_id',
        'version_number',
        'blocks',
        'settings',
        'subject',
        'preheader',
        'reason',
        'created_by',
        'created_at',
    ];

    protected $casts = [
        'blocks' => 'array',
        'settings' => 'array',
        'version_number' => 'integer',
        'created_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return 'email_template_versions';
    }

    /** @return BelongsTo<EmailTemplate, $this> */
    public function template(): BelongsTo
    {
        /** @var class-string<EmailTemplate> $model */
        $model = config('filament-mail-editor.model', EmailTemplate::class);

        return $this->belongsTo($model, 'template_id');
    }
}
