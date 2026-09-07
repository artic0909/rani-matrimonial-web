<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('candidate_code')->nullable()->unique()->after('id');
            $table->string('profile_id')->nullable()->after('candidate_code');
        });

        // Backfill existing candidates if any
        $candidates = DB::table('candidates')->whereNull('candidate_code')->get();
        foreach ($candidates as $candidate) {
            $code = 'RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT);
            DB::table('candidates')->where('id', $candidate->id)->update([
                'candidate_code' => $code,
                'profile_id' => $code
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['candidate_code', 'profile_id']);
        });
    }
};
