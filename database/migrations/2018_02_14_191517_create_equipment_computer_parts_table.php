<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEquipmentComputerPartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipment_computer_parts', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('computer_id')->unsigned()->index('computer_id');
			$table->integer('part_type_id')->nullable();
			$table->string('make', 30);
			$table->string('model', 30)->nullable();
			$table->string('serial', 100)->nullable();
			$table->float('size');
			$table->boolean('unit');
			$table->dateTime('created_at')->nullable();
			$table->boolean('updated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('equipment_computer_parts');
	}

}
