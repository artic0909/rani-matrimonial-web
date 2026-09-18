<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'candidate_id',
        'ticket_code',
        'priority',
        'subject',
        'message',
        'screenshots',
        'status',
        'admin_reply',
        'replied_at',
    ];

    protected $casts = [
        'screenshots' => 'array',
        'replied_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($ticket) {
            if (empty($ticket->ticket_code)) {
                $lastTicket = static::orderBy('id', 'desc')->first();
                $nextNum = $lastTicket ? ($lastTicket->id + 1) : 1;
                $ticket->ticket_code = 'TKTRM' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Relationship with Candidate
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    /**
     * Helper to get full screenshot URLs
     */
    public function getScreenshotUrlsAttribute(): array
    {
        if (empty($this->screenshots) || !is_array($this->screenshots)) {
            return [];
        }

        return array_map(function ($path) {
            if (str_starts_with($path, 'http')) {
                return $path;
            }
            return asset('storage/' . ltrim($path, '/'));
        }, $this->screenshots);
    }

    /**
     * Priority badge CSS class helper
     */
    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            'urgent' => 'badge-danger bg-danger text-white',
            'high' => 'badge-warning bg-warning text-dark',
            'low' => 'badge-info bg-info text-dark',
            default => 'badge-secondary bg-secondary text-white',
        };
    }

    /**
     * Status badge CSS class helper
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'resolved' => 'badge-success bg-success text-white',
            'in_progress' => 'badge-primary bg-primary text-white',
            'closed' => 'badge-dark bg-dark text-white',
            default => 'badge-warning bg-warning text-dark',
        };
    }
}
