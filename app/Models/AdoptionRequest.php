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
        'motivation',
        'status',
        'tracking_code',
    ];

    protected $casts = [
        'status'            => AdoptionRequestStatus::class,
        'previous_pets'     => 'boolean',
        'household_members' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
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
}
