<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimplifyLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('locations', function(Blueprint $table)
		{
			$table->dropColumn('views');
            $table->dropColumn('data');
            $table->text('content');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('locations', function(Blueprint $table)
		{
			$table->integer('views');
            $table->dropColumn('content');
            $table->string('data');
		});
	}

}
