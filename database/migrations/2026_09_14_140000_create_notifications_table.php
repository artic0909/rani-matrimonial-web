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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id')->index();
            $table->unsignedBigInteger('sender_id')->nullable()->index();
            $table->string('type', 50)->default('general');
            $table->string('title')->nullable();
            $table->text('message');
            $table->string('photo')->nullable();
            $table->string('action_url')->nullable();
            $table->string('badge', 50)->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_dismissed')->default(false);
            $table->timestamps();

            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
