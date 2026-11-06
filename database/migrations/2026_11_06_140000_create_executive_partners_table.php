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
        Schema::create('executive_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('mobile', 25);
            $table->string('status', 20)->default('active')->index();
            $table->timestamps();
        });

        // Optional view alias for 'eps'
        try {
            DB::statement("CREATE OR REPLACE VIEW eps AS SELECT * FROM executive_partners");
        } catch (\Throwable $e) {
            // View creation optional depending on DB permissions
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("DROP VIEW IF EXISTS eps");
        } catch (\Throwable $e) {
            // Ignore
        }

        Schema::dropIfExists('executive_partners');
    }
};

