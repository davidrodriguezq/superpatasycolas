<?php

namespace App\Models;

use App\Enums\AnimalCondition;
use App\Enums\HomeCondition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostAdoptionFollowup extends Model
{
    use HasFactory;

    protected $fillable = [
        'adoption_request_id',
        'visit_date',
        'animal_condition',
        'home_condition',
        'observations',
    ];

    protected $casts = [
        'animal_condition' => AnimalCondition::class,
        'home_condition'   => HomeCondition::class,
        'visit_date'       => 'date',
    ];

    public function adoptionRequest(): BelongsTo
    {
        return $this->belongsTo(AdoptionRequest::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(FollowupPhoto::class, 'followup_id');
    }

    public function scopeByAdoptionRequest(Builder $query, int $adoptionRequestId): Builder
    {
        return $query->where('adoption_request_id', $adoptionRequestId);
    }

    public function scopeCritical(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('animal_condition', AnimalCondition::Poor->value)
              ->orWhere('home_condition', HomeCondition::Inadequate->value);
        });
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('visit_date', 'desc');
    }

    public static function criticalCount(): int
    {
        return static::critical()->count();
    }

    public function getAnimalConditionBadgeClassAttribute(): string
    {
        return match ($this->animal_condition) {
            AnimalCondition::Good => 'bg-success',
            AnimalCondition::Fair => 'bg-warning text-dark',
            AnimalCondition::Poor => 'bg-danger',
            default               => 'bg-secondary',
        };
    }

    public function getHomeConditionBadgeClassAttribute(): string
    {
        return match ($this->home_condition) {
            HomeCondition::Adequate         => 'bg-success',
            HomeCondition::NeedsImprovement => 'bg-warning text-dark',
            HomeCondition::Inadequate       => 'bg-danger',
            default                         => 'bg-secondary',
        };
    }

    public function getAnimalConditionLabelAttribute(): string
    {
        return $this->animal_condition?->label() ?? '—';
    }

    public function getHomeConditionLabelAttribute(): string
    {
        return $this->home_condition?->label() ?? '—';
    }

    public function getIsCriticalAttribute(): bool
    {
        return $this->animal_condition === AnimalCondition::Poor
            || $this->home_condition === HomeCondition::Inadequate;
    }
}
