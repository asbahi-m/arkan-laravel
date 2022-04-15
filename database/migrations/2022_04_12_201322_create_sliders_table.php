<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('brief')->nullable();
            $table->string('media');
            $table->string('place')->default('home');
            $table->integer('order')->default(0);
            $table->boolean('is_published')->nullable();
            $table->string('primary_url')->nullable();
            $table->string('primary_btn')->nullable();
            $table->string('secondary_url')->nullable();
            $table->string('secondary_btn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
