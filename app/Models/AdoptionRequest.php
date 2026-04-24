<?php

namespace App\Models;

use App\Enums\AdoptionRequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdoptionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'animal_id',
        'housing_type',
        'household_members',
        'previous_pets',
        'other_pets_description',
        'has_outdoor_space',
        'motivation',
        'status',
        'tracking_code',
        'approved_at',
        'approved_by',
        'rejected_at',
    ];

    protected $casts = [
        'status'            => AdoptionRequestStatus::class,
        'previous_pets'     => 'boolean',
        'has_outdoor_space' => 'boolean',
        'household_members' => 'integer',
        'approved_at'       => 'datetime',
        'rejected_at'       => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function followups(): HasMany
    {
        return $this->hasMany(PostAdoptionFollowup::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', AdoptionRequestStatus::Pending->value);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', AdoptionRequestStatus::Approved->value);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByAnimal(Builder $query, int $animalId): Builder
    {
        return $query->where('animal_id', $animalId);
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
            AdoptionRequestStatus::Pending   => 'bg-warning text-dark',
            AdoptionRequestStatus::Approved  => 'bg-success',
            AdoptionRequestStatus::Rejected  => 'bg-danger',
            AdoptionRequestStatus::Cancelled => 'bg-secondary',
            default                          => 'bg-secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status?->label() ?? '—';
    }
}
