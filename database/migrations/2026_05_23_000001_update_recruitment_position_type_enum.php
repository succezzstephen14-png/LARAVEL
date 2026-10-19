<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('recruitments')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `recruitments` MODIFY `position_type` ENUM('driver','cleaner','gateman','vehicle_owner','security_guard','delivery_rider','maintenance_worker','office_assistant','housekeeper','warehouse_loader') NOT NULL DEFAULT 'driver'");
        } else {
            Schema::table('recruitments', function (Blueprint $table) {
                $table->enum('position_type', ['driver', 'cleaner', 'gateman', 'vehicle_owner', 'security_guard', 'delivery_rider', 'maintenance_worker', 'office_assistant', 'housekeeper', 'warehouse_loader'])->default('driver')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('recruitments')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `recruitments` MODIFY `position_type` ENUM('driver','vehicle_owner','both','tem') NOT NULL DEFAULT 'driver'");
        } else {
            Schema::table('recruitments', function (Blueprint $table) {
                $table->enum('position_type', ['driver', 'vehicle_owner', 'both', 'tem'])->default('driver')->change();
            });
        }
    }
};
