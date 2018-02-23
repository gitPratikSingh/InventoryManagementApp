<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEquipmentPurchaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('equipment_purchase', function(Blueprint $table)
		{
			$table->foreign('equipment_id', 'equipment_purchase_ibfk_1')->references('id')->on('equipment')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('equipment_purchase', function(Blueprint $table)
		{
			$table->dropForeign('equipment_purchase_ibfk_1');
		});
	}

}
