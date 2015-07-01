<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstcachesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('firstcaches', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('planet');
            $table->string('step', 5);
            $table->tinyInteger('star');
            $table->tinyInteger('size');
            $table->tinyInteger('class');
            $table->text('data');
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
		Schema::drop('firstcaches');
	}

}
