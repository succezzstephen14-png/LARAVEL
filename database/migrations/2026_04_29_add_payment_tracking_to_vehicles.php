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
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            }
            if (!Schema::hasColumn('vehicles', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending')->after('approval_status');
            }
            if (!Schema::hasColumn('vehicles', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
            if (Schema::hasColumn('vehicles', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('vehicles', 'payment_reference')) {
                $table->dropColumn('payment_reference');
            }
        });
    }
};
