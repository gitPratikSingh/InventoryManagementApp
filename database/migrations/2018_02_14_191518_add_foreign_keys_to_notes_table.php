<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('notes', function(Blueprint $table)
		{
			$table->foreign('equipment_id', 'notes_ibfk_1')->references('id')->on('equipment')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('notes', function(Blueprint $table)
		{
			$table->dropForeign('notes_ibfk_1');
		});
	}

}
