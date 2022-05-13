<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_sliders', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('locale_id');
            $table->foreign('locale_id')->references('id')->on('locales')->cascadeOnDelete();
            $table->foreignId('slider_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('brief')->nullable();
            $table->string('primary_btn')->nullable();
            $table->string('secondary_btn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_sliders');
    }
}
