<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingWith extends Model
{
    use HasFactory;

    protected $table = 'working_withs';

    protected $fillable = [
        'name',
    ];
}
