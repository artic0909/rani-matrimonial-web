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
        if (!Schema::hasTable('delete_account_requests')) {
            Schema::create('delete_account_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
                $table->text('reason');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->index();
                $table->text('admin_notes')->nullable();
                $table->timestamp('reviewed_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delete_account_requests');
    }
};

