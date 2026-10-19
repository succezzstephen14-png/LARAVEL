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
        Schema::create('cms_report_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->default('Reports & Analytics');
            $table->text('page_description')->nullable();
            $table->string('banner_image_url')->nullable();
            $table->string('banner_color')->default('#0ea5e9');
            $table->text('custom_css')->nullable();
            $table->json('filter_settings')->nullable();
            $table->boolean('show_export_buttons')->default(true);
            $table->boolean('show_filters')->default(true);
            $table->boolean('show_charts')->default(true);
            $table->boolean('show_tables')->default(true);
            $table->boolean('auto_refresh')->default(true);
            $table->integer('refresh_interval')->default(30000); // milliseconds
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_report_settings');
    }
};
