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
        Schema::create('cms_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_page_id')->constrained('cms_pages')->onDelete('cascade');
            $table->string('title');
            $table->string('type')->default('text'); // text, image, video, slider, hero, features
            $table->longText('content')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_color')->nullable();
            $table->integer('order')->default(0);
            $table->json('metadata')->nullable(); // For storing additional section data
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_sections');
    }
};
