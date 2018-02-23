<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('user_id')->nullable();
			$table->string('name', 100)->nullable()->default('0');
			$table->string('name_old', 100)->nullable();
			$table->boolean('is_unit')->nullable()->default(0);
			$table->bigInteger('unit_id')->nullable();
			$table->bigInteger('parent')->nullable();
			$table->bigInteger('parent_old')->nullable();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groups');
	}

}
