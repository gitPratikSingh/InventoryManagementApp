<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('history', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('item_id')->nullable();
			$table->integer('unit_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->enum('screen', array('Equipment','User','Codes','Equipment Notes','OS','Groups','Equipment Make'))->nullable();
			$table->string('field', 20)->nullable();
			$table->enum('action', array('Insert','Update','Delete'))->nullable();
			$table->text('value_old', 65535)->nullable();
			$table->text('value_new', 65535)->nullable();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('history');
	}

}
