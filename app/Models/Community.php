<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'religion_id',
        'name',
    ];

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }
}
