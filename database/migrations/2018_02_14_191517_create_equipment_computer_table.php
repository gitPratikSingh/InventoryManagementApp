<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEquipmentComputerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipment_computer', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('equipment_id')->unsigned()->index('equipment_id');
			$table->bigInteger('memory')->nullable();
			$table->bigInteger('processor')->nullable();
			$table->float('harddrive', 10)->nullable();
			$table->bigInteger('os_id')->unsigned();
			$table->string('os_version', 30)->nullable();
			$table->bigInteger('kernel_id')->nullable();
			$table->string('ip', 50)->nullable()->default('');
			$table->bigInteger('domain_id')->nullable();
			$table->string('ethernet', 100)->nullable()->default('');
			$table->string('hostname', 100)->nullable()->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('equipment_computer');
	}

}
