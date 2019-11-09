<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('network_type')->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('shop_id')->unsigned()->nullable();
            $table->string('product_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_contact')->nullable();
            $table->text('client_comment')->nullable();
            $table->string('client_auto_car')->nullable();
            $table->string('client_auto_year')->nullable();
            $table->string('client_auto_vin')->nullable();
            $table->text('partner_comment')->nullable();
            $table->integer('report_status')->nullable();
            $table->integer('status')->default(0)->nullable();
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
        Schema::dropIfExists('social_reports');
    }
}
