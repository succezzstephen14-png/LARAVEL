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
            // Add profile_picture column if it doesn't exist
            if (!Schema::hasColumn('drivers', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('profile_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            if (Schema::hasColumn('drivers', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
        });
    }
};
