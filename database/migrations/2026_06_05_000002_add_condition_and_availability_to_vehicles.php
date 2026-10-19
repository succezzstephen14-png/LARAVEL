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
        // Add condition and availability_status columns to vehicles table
        if (!Schema::hasColumn('vehicles', 'condition')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->string('condition')->nullable()->comment('Excellent, Very Good, Good, Fair, Needs Maintenance');
            });
        }

        if (!Schema::hasColumn('vehicles', 'availability_status')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->string('availability_status')->default('unavailable')->comment('Admin-controlled: available, in_use, unavailable');
            });
        }

        // Add rejection and suspension reason columns
        if (!Schema::hasColumn('vehicles', 'rejection_reason')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->text('rejection_reason')->nullable();
            });
        }

        if (!Schema::hasColumn('vehicles', 'suspension_reason')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->text('suspension_reason')->nullable();
            });
        }

        // Rename roadworthiness_certificate column if it doesn't exist
        if (!Schema::hasColumn('vehicles', 'roadworthiness_certificate')) {
            // Check if inspection_certificate exists and rename it
            if (Schema::hasColumn('vehicles', 'inspection_certificate')) {
                Schema::table('vehicles', function (Blueprint $table) {
                    $table->renameColumn('inspection_certificate', 'roadworthiness_certificate');
                });
            } else {
                // Create the column if neither exists
                Schema::table('vehicles', function (Blueprint $table) {
                    $table->string('roadworthiness_certificate')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'condition')) {
                $table->dropColumn('condition');
            }
            if (Schema::hasColumn('vehicles', 'availability_status')) {
                $table->dropColumn('availability_status');
            }
        });
    }
};
