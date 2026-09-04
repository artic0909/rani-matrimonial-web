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
        'full_address', 'aadhar_number',

        // Basics & Lifestyle
        'grew_up_in', 'blood_group', 'health_info', 'disability',
        // Religious Background
        'gothra', 'mother_tongue',
        // Astro Details
        'manglik', 'time_of_birth', 'city_of_birth',
        // Family Details
        'mother_profession', 'father_profession', 'family_location', 'sisters_count', 'brothers_count', 'family_financial_status',
        // Education & Career
        'annual_income', 'working_with',
        // Location
        'residency_status', 'zip_code',
        // Partner Preferences
        'pref_age_min', 'pref_age_max', 'pref_height_min', 'pref_height_max',
        'pref_marital_status', 'pref_religion', 'pref_community', 'pref_mother_tongue',
        'pref_country', 'pref_state', 'pref_city', 'pref_education',
        'pref_working_with', 'pref_profession', 'pref_annual_income', 'pref_diet',
        'pref_profile_managed_by',
        // Contact Details
        'contact_display_option',
        // Photo Settings
        'photo_privacy',
        'album_privacy'
    ];

    protected function casts(): array
    {
        return [
            'hobbies_interests' => 'array',
            'selfie_verified' => 'boolean',
        ];
    }

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CandidatePhoto::class, 'candidate_id')->orderBy('sort_order')->orderByDesc('id');
    }
}
