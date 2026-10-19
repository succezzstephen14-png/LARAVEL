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
        Schema::create('cms_footers', function (Blueprint $table) {
            $table->id();
            $table->string('section')->default('main'); // main, column1, column2, column3, bottom
            $table->string('label')->nullable(); // Section heading
            $table->string('title')->nullable(); // Link/item title or footer text
            $table->string('link')->nullable(); // URL for links
            $table->string('icon')->nullable(); // Font Awesome icon
            $table->string('color')->nullable(); // Text/button color
            $table->string('background_color')->nullable(); // Background
            $table->text('content')->nullable(); // Rich content
            $table->string('type')->default('text'); // text, link, social, button, image
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
        Schema::dropIfExists('cms_footer');
    }
};
