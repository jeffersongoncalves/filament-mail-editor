<?php

namespace JeffersonGoncalves\FilamentMailEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\FilamentMailEditor\Enums\ActivityAction;

/**
 * @property int $id
 * @property int $template_id
 * @property ActivityAction $action
 * @property string|null $performed_by
 * @property array<string, mixed>|null $metadata
 * @property Carbon $created_at
 * @property-read EmailTemplate $template
 */
class EmailTemplateActivity extends Model
{
    public $timestamps = false;

    /** @var list<string> */
    protected $fillable = [
        'template_id',
        'action',
        'performed_by',
        'metadata',
        'created_at',
    ];

    protected $casts = [
        'action' => ActivityAction::class,
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return 'email_template_activities';
    }

    /** @return BelongsTo<EmailTemplate, $this> */
    public function template(): BelongsTo
    {
        /** @var class-string<EmailTemplate> $model */
        $model = config('filament-mail-editor.model', EmailTemplate::class);

        return $this->belongsTo($model, 'template_id');
    }
}
