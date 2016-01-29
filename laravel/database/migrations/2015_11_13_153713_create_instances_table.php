<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->string('id', 36);
	    $table->string('name');
	    $table->string('type');
	    $table->string('ownerId',36);
	    $table->string('organization');
	    $table->string('vmId',36);
	    $table->string('description');
            $table->integer('maxSize');
	    $table->boolean('inUse');
            $table->timestamps();
	    $table->primary('id');
            $table->foreign('ownerId')->references('id')->on('demeter_users');
	    $table->foreign('vmId')->references('id')->on('vms');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('instances');
    }
}
