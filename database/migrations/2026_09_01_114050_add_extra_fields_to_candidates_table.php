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
            $table->string('email')->nullable();
            $table->string('community')->nullable();
            $table->string('sub_community')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('height')->nullable();
            $table->string('diet')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->string('college_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'email', 'community', 'sub_community', 'country', 'state', 'city', 
                'marital_status', 'height', 'diet', 'highest_qualification', 'college_name'
            ]);
        });
    }
};
