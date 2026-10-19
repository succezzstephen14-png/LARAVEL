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
        Schema::create('drivers', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('license_number')->unique();
            $table->date('license_expiry');
            $table->enum('license_class', ['A', 'B', 'C', 'D', 'E'])->default('B');
            $table->string('experience_years');
            $table->enum('status', ['available', 'unavailable', 'on_duty'])->default('available');
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->float('rating')->default(0)->min(0)->max(5);
            $table->integer('total_trips')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
