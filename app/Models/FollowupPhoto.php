<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowupPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'followup_id',
        'path',
    ];

    public function followup(): BelongsTo
    {
        return $this->belongsTo(PostAdoptionFollowup::class, 'followup_id');
    }
}
