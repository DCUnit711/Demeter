<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemeterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demeter_users', function (Blueprint $table) {
            $table->string('id', 36);
	    $table->string('netId');
	    $table->string('email');
	    $table->enum('role', ['admin','client']);
            $table->timestamps();
	    $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('demeter_users');
    }
}
