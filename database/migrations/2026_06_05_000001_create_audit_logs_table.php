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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('action'); // e.g., 'license_verification', 'vehicle_approval', 'availability_change'
            $table->text('description');
            $table->string('model_type')->nullable(); // e.g., 'Driver', 'Vehicle', 'Booking'
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('previous_value')->nullable();
            $table->json('new_value')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['action', 'created_at']);
            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
