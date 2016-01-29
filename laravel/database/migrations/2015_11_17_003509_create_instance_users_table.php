<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanceUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_users', function (Blueprint $table) {
            $table->string('id', 36);
	    $table->string('name');
	    $table->string('instanceId',36);
            $table->timestamps();
	    $table->primary('id');
	    $table->foreign('instanceId')->references('id')->on('instances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('instance_users');
    }
}
