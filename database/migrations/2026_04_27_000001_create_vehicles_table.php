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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->string('license_plate')->unique();
            $table->enum('vehicle_type', ['car', 'van', 'truck', 'motorcycle'])->default('car');
            $table->enum('status', ['available', 'unavailable', 'maintenance'])->default('available');
            $table->text('description')->nullable();
            $table->text('image_url')->nullable();
            $table->integer('capacity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
