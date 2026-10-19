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
        Schema::create('cms_cards', function (Blueprint $table) {
            $table->id();
            $table->string('section')->nullable(); // Which section contains this card (features, testimonials, etc.)
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('image_url')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon
            $table->string('badge')->nullable(); // Badge text
            $table->string('badge_color')->default('primary');
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_color')->nullable();
            $table->string('background_color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('type')->default('default'); // default, feature, testimonial, service, stats
            $table->json('metadata')->nullable(); // Additional data
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
        Schema::dropIfExists('cms_cards');
    }
};
