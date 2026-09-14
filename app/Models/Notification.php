<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'candidate_id',
        'sender_id',
        'type',
        'title',
        'message',
        'photo',
        'action_url',
        'badge',
        'is_read',
        'is_dismissed',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'is_dismissed' => 'boolean',
        ];
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'sender_id');
    }
}
