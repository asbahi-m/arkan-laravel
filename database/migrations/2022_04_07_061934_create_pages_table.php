<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('update_by')->nullable();
            $table->string('title')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('is_marker')->nullable();
            $table->json('templates')->nullable();
            $table->string('image')->nullable();
            $table->boolean('view_image')->nullable()->default(true);
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
