<?php

namespace App\Models;

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

    public function scopeBySex(Builder $query, string $sex): Builder
    {
        return $query->where('sex', $sex);
    }

    public function scopeByEntryType(Builder $query, EntryType $type): Builder
    {
        return $query->where('entry_type', $type->value);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('breed', 'like', "%{$search}%");
        });
    }

    public function getPrimaryPhotoAttribute(): ?AnimalPhoto
    {
        return $this->photos->firstWhere('is_primary', true) ?? $this->photos->first();
    }

    public function getAgeFormattedAttribute(): string
    {
        $age = $this->approximate_age;

        if ($age === null || $age === '') {
            return '—';
        }

        return is_numeric($age) ? "{$age} años" : $age;
    }

    /**
     * Estados a los que el animal puede transicionar desde su estado actual.
     *
     * @return array<int, AnimalStatus>
     */
    public function allowedStatusTransitions(): array
    {
        return match ($this->status) {
            AnimalStatus::Available  => [AnimalStatus::Available, AnimalStatus::InProcess, AnimalStatus::Quarantine, AnimalStatus::Deceased],
            AnimalStatus::InProcess  => [AnimalStatus::InProcess, AnimalStatus::Available, AnimalStatus::Adopted],
            AnimalStatus::Quarantine => [AnimalStatus::Quarantine, AnimalStatus::Available, AnimalStatus::Deceased],
            AnimalStatus::Adopted    => [AnimalStatus::Adopted, AnimalStatus::Available],
            AnimalStatus::Deceased   => [AnimalStatus::Deceased],
            default                  => [$this->status],
        };
    }

    public function canTransitionTo(AnimalStatus $newStatus): bool
    {
        return in_array($newStatus, $this->allowedStatusTransitions(), true);
    }

    public function hasActiveAdoptionRequests(): bool
    {
        return $this->adoptionRequests()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }
}
