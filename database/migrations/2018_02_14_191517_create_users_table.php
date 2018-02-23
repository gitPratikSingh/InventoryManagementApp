<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('access_id')->nullable()->default(0);
			$table->bigInteger('department_id')->nullable();
			$table->bigInteger('unit_id')->unsigned()->index('unit_id');
			$table->bigInteger('group_id')->nullable();
			$table->string('first_name', 20)->nullable();
			$table->string('middle_name', 20)->nullable();
			$table->string('last_name', 20)->nullable();
			$table->string('email', 50)->nullable();
			$table->string('unity_id', 20)->nullable();
			$table->text('columns', 65535)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->boolean('status')->nullable();
			$table->dateTime('last_activity')->nullable();
			$table->timestamps();
			$table->index('unity_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
