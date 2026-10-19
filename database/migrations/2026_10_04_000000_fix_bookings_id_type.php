<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql' || ! Schema::hasTable('bookings')) {
            return;
        }

        $column = DB::selectOne("SHOW COLUMNS FROM bookings WHERE Field = 'id'");

        if (! $column || ! preg_match('/^(int|bigint|tinyint|smallint|mediumint)/i', (string) $column->Type)) {
            return;
        }

        DB::statement('ALTER TABLE bookings DROP PRIMARY KEY');
        DB::statement('ALTER TABLE bookings MODIFY COLUMN id VARCHAR(36) NOT NULL');
        DB::statement('ALTER TABLE bookings ADD PRIMARY KEY (id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql' || ! Schema::hasTable('bookings')) {
            return;
        }

        $column = DB::selectOne("SHOW COLUMNS FROM bookings WHERE Field = 'id'");

        if (! $column || ! preg_match('/^varchar/i', (string) $column->Type)) {
            return;
        }

        DB::statement('ALTER TABLE bookings DROP PRIMARY KEY');
        DB::statement('ALTER TABLE bookings MODIFY COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE bookings ADD PRIMARY KEY (id)');
    }
};
