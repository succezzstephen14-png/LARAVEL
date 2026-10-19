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
        Schema::create('cms_post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_post_id')->constrained('cms_posts')->onDelete('cascade');
            $table->foreignId('cms_tag_id')->constrained('cms_tags')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['cms_post_id', 'cms_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_post_tag');
    }
};
