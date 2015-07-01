<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('points', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->unique();
            $table->integer('stars');
            $table->integer('planets');
            $table->integer('points');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('points');
	}

}
