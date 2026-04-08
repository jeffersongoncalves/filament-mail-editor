<?php

namespace JeffersonGoncalves\FilamentMailEditor\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\FilamentMailEditor\Support\HtmlExporter;
use JeffersonGoncalves\FilamentMailEditor\Support\VariableEngine;

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
 * @property string $status
 * @property string|null $locked_by
 * @property Carbon|null $locked_at
 * @property string|null $approved_by
 * @property Carbon|null $approved_at
 * @property int|null $category_id
 * @property-read EmailTemplateCategory|null $templateCategory
 * @property-read Collection<int, EmailTemplateVariant> $variants
 * @property-read Collection<int, EmailTemplateVersion> $versions
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
        'category_id',
        'is_active',
        'status',
        'locked_by',
        'locked_at',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'blocks' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'locked_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return config('filament-mail-editor.table_name', 'email_templates');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** @return BelongsTo<EmailTemplateCategory, $this> */
    public function templateCategory(): BelongsTo
    {
        return $this->belongsTo(EmailTemplateCategory::class, 'category_id');
    }

    /** @return HasMany<EmailTemplateVariant, $this> */
    public function variants(): HasMany
    {
        return $this->hasMany(EmailTemplateVariant::class, 'template_id');
    }

    /** @return HasMany<EmailTemplateVersion, $this> */
    public function versions(): HasMany
    {
        return $this->hasMany(EmailTemplateVersion::class, 'template_id');
    }

    /**
     * Create a version snapshot of the current state.
     */
    public function createVersion(?string $reason = null, ?string $createdBy = null): EmailTemplateVersion
    {
        $latestVersion = $this->versions()->max('version_number') ?? 0;

        return $this->versions()->create([
            'version_number' => $latestVersion + 1,
            'blocks' => $this->blocks ?? [],
            'settings' => $this->settings,
            'subject' => $this->subject,
            'preheader' => $this->preheader,
            'reason' => $reason,
            'created_by' => $createdBy,
            'created_at' => now(),
        ]);
    }

    // ──── Workflow ────

    public const STATUS_DRAFT = 'draft';

    public const STATUS_REVIEW = 'review';

    public const STATUS_APPROVED = 'approved';

    /**
     * Submit template for review.
     */
    public function submitForReview(): void
    {
        $this->update(['status' => self::STATUS_REVIEW]);
    }

    /**
     * Approve the template.
     */
    public function approve(?string $approvedBy = null): void
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'approved_by' => $approvedBy ?? self::resolveCurrentUserName(),
            'approved_at' => now(),
        ]);
    }

    /**
     * Reject and send back to draft.
     */
    public function rejectToDraft(): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Lock the template for editing.
     */
    public function lock(?string $lockedBy = null): void
    {
        $this->update([
            'locked_by' => $lockedBy ?? self::resolveCurrentUserName(),
            'locked_at' => now(),
        ]);
    }

    /**
     * Unlock the template.
     */
    public function unlock(): void
    {
        $this->update([
            'locked_by' => null,
            'locked_at' => null,
        ]);
    }

    /**
     * Check if the template is locked by someone else.
     */
    public function isLockedByOther(?string $currentUser = null): bool
    {
        if (! $this->locked_by) {
            return false;
        }

        $currentUser = $currentUser ?? self::resolveCurrentUserName();

        return $this->locked_by !== $currentUser;
    }

    /**
     * Check if template is editable (draft or review, not locked by other).
     */
    public function isEditable(?string $currentUser = null): bool
    {
        if ($this->status === self::STATUS_APPROVED) {
            return false;
        }

        return ! $this->isLockedByOther($currentUser);
    }

    /**
     * Restore template to a specific version.
     */
    public function restoreVersion(int $versionId): void
    {
        $version = $this->versions()->findOrFail($versionId);

        $this->update([
            'blocks' => $version->blocks,
            'settings' => $version->settings,
            'subject' => $version->subject,
            'preheader' => $version->preheader,
        ]);
    }

    protected static function resolveCurrentUserName(): ?string
    {
        /** @var (Authenticatable&object{name?: string, email?: string})|null $user */
        $user = auth()->user();

        return $user->name ?? $user->email ?? null;
    }

    public function render(array $variables = []): string
    {
        $engine = new VariableEngine;
        $blocks = $this->blocks ?? [];

        $blocks = array_map(function (array $block) use ($engine, $variables) {
            $block['props'] = $engine->processProps($block['props'], $variables);

            return $block;
        }, $blocks);

        return app(HtmlExporter::class)->export($blocks, $this->settings ?? []);
    }
}
