<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demeter_user_instance', function (Blueprint $table) {
            $table->string('demeter_user_id',36);
	    $table->string('instance_id',36);
            $table->timestamps();
	    $table->foreign('demeter_user_id')->references('id')->on('demeter_users')->onDelete('cascade');
            $table->foreign('instance_id')->references('id')->on('instances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('demeter_user_instance');
    }
}
