<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRolesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('permission_roles', function (Blueprint $table) {
      $table->unsignedInteger('permission_id')->index();
      $table->unsignedInteger('role_id')->index();

      $table->primary(['permission_id', 'role_id']);

    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('permission_roles');
  }
}
