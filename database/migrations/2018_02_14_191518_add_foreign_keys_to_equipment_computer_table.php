<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEquipmentComputerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('equipment_computer', function(Blueprint $table)
		{
			$table->foreign('equipment_id', 'Equipment ID')->references('id')->on('equipment')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('equipment_computer', function(Blueprint $table)
		{
			$table->dropForeign('Equipment ID');
		});
	}

}
