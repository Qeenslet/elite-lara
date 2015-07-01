<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessageToModerations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('moderations', function(Blueprint $table)
		{
			$table->enum('request', ['unsent', 'sent']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('moderations', function(Blueprint $table)
		{
			$table->dropColumn('request');
		});
	}

}
