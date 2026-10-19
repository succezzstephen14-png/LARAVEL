<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recruitment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('position_type');
            $table->string('location')->nullable();
            $table->text('requirements')->nullable();
            $table->json('documents')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recruitment_requests');
    }
};
