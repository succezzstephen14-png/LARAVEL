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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('position_type', ['driver', 'cleaner', 'gateman', 'vehicle_owner', 'security_guard', 'delivery_rider', 'maintenance_worker', 'office_assistant', 'housekeeper', 'warehouse_loader'])->default('driver');
            $table->string('location');
            $table->text('requirements')->nullable();
            $table->decimal('salary_range_min', 10, 2)->nullable();
            $table->decimal('salary_range_max', 10, 2)->nullable();
            $table->enum('status', ['open', 'closed', 'filled'])->default('open');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('posted_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
