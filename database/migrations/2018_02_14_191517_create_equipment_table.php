<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEquipmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipment', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('equipment_name', 200)->nullable()->default('');
			$table->bigInteger('type_id')->unsigned()->nullable();
			$table->string('serial_number', 200)->nullable()->default('');
			$table->string('barcode', 200)->nullable()->default('');
			$table->string('cams', 100)->nullable()->default('');
			$table->bigInteger('make_id')->unsigned()->nullable();
			$table->string('model', 40)->nullable();
			$table->bigInteger('department_id')->unsigned()->nullable();
			$table->string('building_id', 11)->nullable();
			$table->string('room', 20)->nullable()->default('');
			$table->string('owner', 35)->nullable();
			$table->string('primary_user', 35)->nullable();
			$table->text('config', 65535)->nullable();
			$table->bigInteger('unit_id')->nullable();
			$table->bigInteger('group_id')->unsigned()->nullable();
			$table->string('warranty', 100)->nullable()->default('');
			$table->boolean('personal')->nullable();
			$table->boolean('offsite')->nullable();
			$table->boolean('surplused')->nullable();
			$table->boolean('retired')->nullable();
			$table->boolean('active')->default(1);
			$table->dateTime('surplused_at')->nullable();
			$table->dateTime('retired_at')->nullable();
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
		Schema::drop('equipment');
	}

}
