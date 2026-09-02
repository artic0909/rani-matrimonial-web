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
            $table->string('middle_name')->nullable();
            $table->string('living_in')->nullable();
            $table->text('college_address')->nullable();
            $table->string('income_type')->nullable(); // yearly, monthly
            $table->string('profession')->nullable();
            $table->string('designation')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->text('about_yourself')->nullable();
            $table->string('profile_picture')->nullable();
            $table->json('hobbies_interests')->nullable();
            $table->boolean('selfie_verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'middle_name', 'living_in', 'college_address', 'income_type',
                'profession', 'designation', 'company_name', 'company_address',
                'about_yourself', 'profile_picture', 'hobbies_interests', 'selfie_verified'
            ]);
        });
    }
};
