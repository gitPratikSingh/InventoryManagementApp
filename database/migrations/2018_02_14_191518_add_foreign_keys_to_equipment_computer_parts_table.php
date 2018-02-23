<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEquipmentComputerPartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('equipment_computer_parts', function(Blueprint $table)
		{
			$table->foreign('computer_id', 'Computer ID')->references('id')->on('equipment_computer')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('equipment_computer_parts', function(Blueprint $table)
		{
			$table->dropForeign('Computer ID');
		});
	}

}
