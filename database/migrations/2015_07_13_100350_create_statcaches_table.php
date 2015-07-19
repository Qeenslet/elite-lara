<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatcachesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statcaches', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('planets');
            $table->integer('regions');
            $table->integer('tf');
            $table->integer('addresses');
            $table->integer('latest_stars');
            $table->integer('latest_planets');
            $table->integer('latest_regions');
            $table->integer('latest_addresses');
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
		Schema::drop('statcaches');
	}

}
