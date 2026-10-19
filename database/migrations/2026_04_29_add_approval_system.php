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
        // Add approval_status to drivers table
        Schema::table('drivers', function (Blueprint $table) {
            if (!Schema::hasColumn('drivers', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('drivers', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
            if (!Schema::hasColumn('drivers', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
        });

        // Add approval_status to vehicles table
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('vehicles', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
        });

        // Add approval_status to recruitments table
        Schema::table('recruitments', function (Blueprint $table) {
            if (!Schema::hasColumn('recruitments', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('recruitments', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
            if (!Schema::hasColumn('recruitments', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
        });

        // Create bookings table
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('cascade');
            $table->string('recruitment_id')->nullable();
            $table->foreign('recruitment_id')->references('id')->on('recruitments')->onDelete('cascade');
            
            $table->enum('booking_type', ['driver', 'vehicle', 'recruitment'])->default('driver');
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->dateTime('booking_date');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_reference')->nullable();
            $table->timestamp('payment_date')->nullable();
            
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'rejection_reason', 'approved_at']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'rejection_reason', 'approved_at']);
        });

        Schema::table('recruitments', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'rejection_reason', 'approved_at']);
        });

        Schema::dropIfExists('bookings');
    }
};
