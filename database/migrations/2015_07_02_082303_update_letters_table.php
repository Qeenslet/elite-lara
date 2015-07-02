<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLettersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('letters', function(Blueprint $table)
		{
			$table->enum('show_sender', ['true', 'false']);
            $table->enum('show_reciever', ['true', 'false']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('letters', function(Blueprint $table)
		{
			$table->dropColumn('show_sender');
            $table->dropColumn('show_reciever');
		});
	}

}
