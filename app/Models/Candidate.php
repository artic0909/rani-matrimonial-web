<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidate extends Authenticatable
{
    protected $fillable = [
        'mobile', 'profile_for', 'gender', 'first_name', 'last_name', 'dob', 'religion',
        'email', 'community', 'sub_community', 'country', 'state', 'city',
        'marital_status', 'height', 'diet', 'highest_qualification', 'college_name'
    ];
}
