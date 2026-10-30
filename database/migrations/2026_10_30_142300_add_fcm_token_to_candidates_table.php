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
        if (Schema::hasTable('candidates') && !Schema::hasColumn('candidates', 'fcm_token')) {
            Schema::table('candidates', function (Blueprint $table) {
                $table->text('fcm_token')->nullable()->after('mobile');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('candidates') && Schema::hasColumn('candidates', 'fcm_token')) {
            Schema::table('candidates', function (Blueprint $table) {
                $table->dropColumn('fcm_token');
            });
        }
    }
};

