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
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'tracking_status')) {
                $table->enum('tracking_status', ['pending', 'assigned', 'in_transit', 'arrived', 'completed', 'cancelled'])
                    ->default('pending')
                    ->after('status');
            }

            if (!Schema::hasColumn('bookings', 'tracking_location')) {
                $table->string('tracking_location')->nullable()->after('tracking_status');
            }

            if (!Schema::hasColumn('bookings', 'tracking_notes')) {
                $table->text('tracking_notes')->nullable()->after('tracking_location');
            }

            if (!Schema::hasColumn('bookings', 'tracking_updated_at')) {
                $table->timestamp('tracking_updated_at')->nullable()->after('tracking_notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'tracking_updated_at')) {
                $table->dropColumn('tracking_updated_at');
            }
            if (Schema::hasColumn('bookings', 'tracking_notes')) {
                $table->dropColumn('tracking_notes');
            }
            if (Schema::hasColumn('bookings', 'tracking_location')) {
                $table->dropColumn('tracking_location');
            }
            if (Schema::hasColumn('bookings', 'tracking_status')) {
                $table->dropColumn('tracking_status');
            }
        });
    }
};
