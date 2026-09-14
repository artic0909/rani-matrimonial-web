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
        Schema::create('blueticks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id')->index();
            $table->string('aadhar_number', 12);
            $table->string('aadhar_photo_front');
            $table->string('aadhar_photo_back');
            $table->tinyInteger('is_accept')->default(0)->comment('0=Pending, 1=Accepted, 2=Rejected');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blueticks');
    }
};
