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
        Schema::create('cms_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content');
            $table->string('block_type')->default('reusable'); // reusable, custom
            $table->json('settings')->nullable(); // For storing block styling and options
            $table->string('thumbnail')->nullable();
            $table->integer('usage_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_blocks');
    }
};
