<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThirdcachesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('thirdcaches', function(Blueprint $table)
		{
			$table->increments('id');
            $table->tinyInteger('star');
            $table->smallInteger('size');
            $table->smallInteger('class');
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
		Schema::drop('thirdcaches');
	}

}
