<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_sign', 2)->unique();
            $table->boolean('is_default')->nullable()->unique();
            $table->boolean('status_on_site')->default(true);
            $table->boolean('status_on_dashboard')->default(true);
            $table->boolean('is_disabled')->nullable();
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
        Schema::dropIfExists('locales');
    }
}
