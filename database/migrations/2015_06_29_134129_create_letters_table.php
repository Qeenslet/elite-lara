<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLettersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('letters', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('sender');
            $table->integer('reciever');
            $table->string('header');
            $table->text('body');
            $table->enum('status', ['unread', 'read']);
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
		Schema::drop('letters');
	}

}
