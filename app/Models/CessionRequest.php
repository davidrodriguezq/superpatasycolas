<?php

namespace App\Models;

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
        'reason',
        'animal_condition',
        'status',
    ];

    protected $casts = [
        'status' => CessionRequestStatus::class,
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
}
