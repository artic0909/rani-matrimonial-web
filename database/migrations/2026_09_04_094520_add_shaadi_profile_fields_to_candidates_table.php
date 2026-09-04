<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Basics & Lifestyle
            $table->string('grew_up_in')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('health_info')->nullable();
            $table->string('disability')->nullable();

            // Religious Background
            $table->string('gothra')->nullable();
            $table->string('mother_tongue')->nullable();

            // Astro Details
            $table->string('manglik')->nullable();
            $table->string('time_of_birth')->nullable();
            $table->string('city_of_birth')->nullable();

            // Family Details
            $table->string('mother_profession')->nullable();
            $table->string('father_profession')->nullable();
            $table->string('family_location')->nullable();
            $table->integer('sisters_count')->nullable();
            $table->integer('brothers_count')->nullable();
            $table->string('family_financial_status')->nullable();

            // Education & Career
            $table->string('annual_income')->nullable();
            $table->string('working_with')->nullable();

            // Location
            $table->string('residency_status')->nullable();
            $table->string('zip_code')->nullable();

            // Partner Preferences
            $table->integer('pref_age_min')->nullable();
            $table->integer('pref_age_max')->nullable();
            $table->string('pref_height_min')->nullable();
            $table->string('pref_height_max')->nullable();
            $table->string('pref_marital_status')->nullable();
            $table->string('pref_religion')->nullable();
            $table->string('pref_community')->nullable();
            $table->string('pref_mother_tongue')->nullable();
            $table->string('pref_country')->nullable();
            $table->string('pref_state')->nullable();
            $table->string('pref_city')->nullable();
            $table->string('pref_education')->nullable();
            $table->string('pref_working_with')->nullable();
            $table->string('pref_profession')->nullable();
            $table->string('pref_annual_income')->nullable();
            $table->string('pref_diet')->nullable();
            $table->string('pref_profile_managed_by')->nullable();

            // Contact Details
            $table->string('contact_display_option')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'grew_up_in', 'blood_group', 'health_info', 'disability',
                'gothra', 'mother_tongue', 'manglik', 'time_of_birth', 'city_of_birth',
                'mother_profession', 'father_profession', 'family_location', 'sisters_count', 'brothers_count', 'family_financial_status',
                'annual_income', 'working_with', 'residency_status', 'zip_code',
                'pref_age_min', 'pref_age_max', 'pref_height_min', 'pref_height_max',
                'pref_marital_status', 'pref_religion', 'pref_community', 'pref_mother_tongue',
                'pref_country', 'pref_state', 'pref_city', 'pref_education',
                'pref_working_with', 'pref_profession', 'pref_annual_income', 'pref_diet',
                'pref_profile_managed_by', 'contact_display_option'
            ]);
        });
    }
};
