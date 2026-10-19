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
        Schema::table('drivers', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('emergency_phone');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->timestamp('last_location_update')->nullable()->after('longitude');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('inspection_certificate');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->timestamp('last_location_update')->nullable()->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'last_location_update']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'last_location_update']);
        });
    }
};
