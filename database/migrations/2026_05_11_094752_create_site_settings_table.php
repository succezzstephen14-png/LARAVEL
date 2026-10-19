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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('Driver Recruitment Platform');
            $table->text('site_description')->nullable();
            $table->string('primary_color')->default('#007bff');
            $table->string('secondary_color')->default('#6c757d');
            $table->string('font_family')->default('Arial, sans-serif');
            $table->string('font_color')->default('#000000');
            $table->string('background_color')->default('#ffffff');
            $table->string('background_image')->nullable();
            $table->text('custom_css')->nullable();
            $table->text('home_page_content')->nullable();
            $table->text('footer_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
