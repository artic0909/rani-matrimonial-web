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
        Schema::create('gp_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gp_id')->constrained('ground_partners')->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->string('payment_id', 100)->nullable();
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->string('payment_status', 30)->default('pending')->index(); // 'pending', 'paid'
            $table->dateTime('register_date')->useCurrent()->index();
            $table->dateTime('payment_date')->nullable()->index();
            $table->timestamps();

            $table->unique(['candidate_id', 'gp_id']);
        });

        // View alias for 'gp_refferals'
        try {
            DB::statement("CREATE OR REPLACE VIEW gp_refferals AS SELECT * FROM gp_referrals");
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
            DB::statement("DROP VIEW IF EXISTS gp_refferals");
        } catch (\Throwable $e) {}

        Schema::dropIfExists('gp_referrals');
    }
};

