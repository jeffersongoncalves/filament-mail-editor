<?php

namespace JeffersonGoncalves\FilamentMailEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\FilamentMailEditor\Enums\NotificationType;

/**
 * @property int $id
 * @property int $template_id
 * @property NotificationType $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string|null $message
 * @property Carbon|null $read_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read EmailTemplate $template
 * @property-read Model $notifiable
 */
class EmailTemplateNotification extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'template_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'message',
        'read_at',
    ];

    protected $casts = [
        'type' => NotificationType::class,
        'read_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return 'email_template_notifications';
    }

    /** @return BelongsTo<EmailTemplate, $this> */
    public function template(): BelongsTo
    {
        /** @var class-string<EmailTemplate> $model */
        $model = config('filament-mail-editor.model', EmailTemplate::class);

        return $this->belongsTo($model, 'template_id');
    }

    /** @return MorphTo<Model, $this> */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
