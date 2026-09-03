<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidate extends Authenticatable
{
    protected $fillable = [
        'mobile', 'profile_for', 'gender', 'first_name', 'last_name', 'dob', 'religion',
        'email', 'community', 'sub_community', 'country', 'state', 'city',
        'marital_status', 'height', 'diet', 'highest_qualification', 'college_name',
        
        'middle_name', 'living_in', 'college_address', 'income_type',
        'profession', 'designation', 'company_name', 'company_address',
        'about_yourself', 'profile_picture', 'hobbies_interests', 'selfie_verified',
        'full_address', 'aadhar_number'
    ];

    protected function casts(): array
    {
        return [
            'hobbies_interests' => 'array',
            'selfie_verified' => 'boolean',
        ];
    }
}
