<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    use HasFactory;

    protected $table = 'helps';

    protected $fillable = [
        'name',
        'email',
        'country_code',
        'mobile',
        'subject',
        'message',
        'status',
        'reply_message',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Scope for pending helps
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for replied helps
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Get full phone with country code
     */
    public function getFullPhoneAttribute(): string
    {
        return trim(($this->country_code ?? '+91') . ' ' . $this->mobile);
    }
}
