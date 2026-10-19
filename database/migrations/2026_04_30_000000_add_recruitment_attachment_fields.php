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
        Schema::table('recruitments', function (Blueprint $table) {
            if (!Schema::hasColumn('recruitments', 'job_brief')) {
                $table->string('job_brief')->nullable()->after('requirements');
            }
            if (!Schema::hasColumn('recruitments', 'offer_document')) {
                $table->string('offer_document')->nullable()->after('job_brief');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitments', function (Blueprint $table) {
            if (Schema::hasColumn('recruitments', 'job_brief')) {
                $table->dropColumn('job_brief');
            }
            if (Schema::hasColumn('recruitments', 'offer_document')) {
                $table->dropColumn('offer_document');
            }
        });
    }
};
