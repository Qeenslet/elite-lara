<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanetsValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planets_values', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('planet');
            $table->integer('value');
            $table->float('modifier');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('planets_values');
	}

}
