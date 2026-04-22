<?php

namespace App\Models;

use App\Enums\AnimalCondition;
use App\Enums\AnimalSpecies;
use App\Enums\AnimalStatus;
use App\Enums\EntryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'sex',
        'approximate_age',
        'weight',
        'health_status',
        'description',
        'status',
        'entry_date',
        'entry_type',
        'user_id',
    ];

    protected $casts = [
        'species'    => AnimalSpecies::class,
        'status'     => AnimalStatus::class,
        'entry_type' => EntryType::class,
        'entry_date' => 'date',
        'weight'     => 'decimal:2',
    ];

    public function cedente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(AnimalPhoto::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function adoptionRequests(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class);
    }

    public function cessionRequests(): HasMany
    {
        return $this->hasMany(CessionRequest::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', AnimalStatus::Available->value);
    }

    public function scopeBySpecies(Builder $query, AnimalSpecies $species): Builder
    {
        return $query->where('species', $species->value);
    }

    public function scopeByStatus(Builder $query, AnimalStatus $status): Builder
    {
        return $query->where('status', $status->value);
    }
}
