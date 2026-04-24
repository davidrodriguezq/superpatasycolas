<?php

namespace App\Models;

use App\Enums\AnimalCondition;
use App\Enums\CessionRequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CessionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'animal_id',
        'animal_name',
        'animal_species',
        'animal_breed',
        'animal_sex',
        'animal_approximate_age',
        'animal_weight',
        'animal_description',
        'reason',
        'urgency',
        'animal_condition',
        'status',
    ];

    protected $casts = [
        'status'           => CessionRequestStatus::class,
        'animal_condition' => AnimalCondition::class,
        'animal_weight'    => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', CessionRequestStatus::Pending->value);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            CessionRequestStatus::Pending  => 'bg-warning text-dark',
            CessionRequestStatus::Accepted => 'bg-success',
            CessionRequestStatus::Rejected => 'bg-danger',
            default                        => 'bg-secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }
}
