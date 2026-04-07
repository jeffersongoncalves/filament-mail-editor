<?php

namespace JeffersonGoncalves\FilamentMailEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $template_id
 * @property string $name
 * @property array<int, array{id: string, type: string, props: array<string, mixed>}> $blocks
 * @property array<string, mixed>|null $settings
 * @property int $send_percentage
 * @property bool $is_winner
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class EmailTemplateVariant extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'template_id',
        'name',
        'blocks',
        'settings',
        'send_percentage',
        'is_winner',
    ];

    protected $casts = [
        'blocks' => 'array',
        'settings' => 'array',
        'send_percentage' => 'integer',
        'is_winner' => 'boolean',
    ];

    public function getTable(): string
    {
        return 'email_template_variants';
    }

    /** @return BelongsTo<EmailTemplate, $this> */
    public function template(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}
