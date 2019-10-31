<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteTracksTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('route_tracks', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('route');
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
    Schema::dropIfExists('route_tracks');
  }
}
