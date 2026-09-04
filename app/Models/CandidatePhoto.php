<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidatePhoto extends Model
{
    protected $table = 'candidate_photos';

    protected $fillable = [
        'candidate_id',
        'photo_path',
        'is_profile_picture',
        'caption',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_profile_picture' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->photo_path);
    }
}
