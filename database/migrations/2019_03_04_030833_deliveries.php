<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Deliveries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email_to', 255);
            $table->string('name_to', 255);
            $table->string('subject', 255);
            $table->text('body');
            $table->integer('status_id')->unsigned();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('delivery_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
