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
        Schema::table('cms_sections', function (Blueprint $table) {
            // Visual styling fields
            $table->string('text_color')->nullable()->after('background_color');
            $table->string('button_text')->nullable()->after('text_color');
            $table->string('button_link')->nullable()->after('button_text');
            $table->string('button_color')->nullable()->after('button_link');
            $table->string('button_text_color')->nullable()->after('button_color');
            $table->string('image_url')->nullable()->after('button_text_color');
            $table->string('image_alt')->nullable()->after('image_url');
            $table->string('heading_style')->default('h2')->after('image_alt'); // h1, h2, h3, h4, h5, h6
            $table->string('heading_size')->default('normal')->after('heading_style'); // small, normal, large, xlarge
            $table->string('padding')->default('standard')->after('heading_size'); // none, small, standard, large
            $table->string('text_alignment')->default('left')->after('padding'); // left, center, right
            $table->string('layout_style')->default('default')->after('text_alignment'); // default, grid, masonry, carousel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_sections', function (Blueprint $table) {
            $table->dropColumn([
                'text_color',
                'button_text',
                'button_link',
                'button_color',
                'button_text_color',
                'image_url',
                'image_alt',
                'heading_style',
                'heading_size',
                'padding',
                'text_alignment',
                'layout_style'
            ]);
        });
    }
};
