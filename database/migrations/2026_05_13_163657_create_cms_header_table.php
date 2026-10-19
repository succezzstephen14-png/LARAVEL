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
        Schema::create('cms_header', function (Blueprint $table) {
            $table->id();
            $table->string('section')->default('main'); // main, nav, meta, banner
            $table->string('label')->nullable(); // Item label
            $table->string('title')->nullable(); // Item text
            $table->string('link')->nullable(); // URL
            $table->string('icon')->nullable(); // Icon class
            $table->string('color')->nullable(); // Color
            $table->string('background_color')->nullable(); // Background
            $table->string('image_url')->nullable(); // Logo or banner image
            $table->string('type')->default('text'); // text, link, logo, button, banner
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->index(['section', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_header');
    }
};
