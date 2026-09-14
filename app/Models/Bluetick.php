<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bluetick extends Model
{
    protected $table = 'blueticks';

    protected $fillable = [
        'candidate_id',
        'aadhar_number',
        'aadhar_photo_front',
        'aadhar_photo_back',
        'is_accept',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'is_accept' => 'integer',
        ];
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
