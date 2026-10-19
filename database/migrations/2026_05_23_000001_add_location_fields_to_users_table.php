<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tracking_location')) {
                $table->string('tracking_location')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('tracking_location');
            }
            if (!Schema::hasColumn('users', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('users', 'last_location_update')) {
                $table->timestamp('last_location_update')->nullable()->after('longitude');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tracking_location')) {
                $table->dropColumn('tracking_location');
            }
            if (Schema::hasColumn('users', 'latitude')) {
                $table->dropColumn('latitude');
            }
            if (Schema::hasColumn('users', 'longitude')) {
                $table->dropColumn('longitude');
            }
            if (Schema::hasColumn('users', 'last_location_update')) {
                $table->dropColumn('last_location_update');
            }
        });
    }
};
