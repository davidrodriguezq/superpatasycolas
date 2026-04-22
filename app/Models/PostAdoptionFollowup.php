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

    // Casos con condición crítica: animal en mal estado u hogar inadecuado
    public function scopeCritical(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('animal_condition', AnimalCondition::Poor->value)
              ->orWhere('home_condition', HomeCondition::Inadequate->value);
        });
    }
}
