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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->integer('user_id');
            $table->string('car_name');
            $table->string('link');
            $table->string('link_image');
            $table->string('year');
            $table->string('fuel')->nullable();
            $table->string('doors')->nullable();
            $table->string('kilometers');
            $table->string('gearbox');
            $table->string('color');
            $table->string('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
