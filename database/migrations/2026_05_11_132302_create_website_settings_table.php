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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, json, file, color, etc.
            $table->string('group')->default('general'); // general, appearance, seo, social, etc.
            $table->string('label');
            $table->text('description')->nullable();
            $table->json('options')->nullable(); // For select/radio options
            $table->boolean('is_public')->default(true); // Whether it's accessible via API
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
