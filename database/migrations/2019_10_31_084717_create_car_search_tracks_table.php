<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarSearchTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_search_tracks', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('car_type_id')->nullable();
          $table->integer('car_make_id')->nullable();
          $table->integer('car_model_id')->nullable();
          $table->integer('car_generation_id')->nullable();
          $table->date('date');
          $table->integer('click_count');
          $table->integer('click_count_unique');
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
        Schema::dropIfExists('search_tracks');
    }
}
