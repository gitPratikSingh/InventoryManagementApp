<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEquipmentPurchaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipment_purchase', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('equipment_id')->unsigned()->index('equipment_id');
			$table->bigInteger('acct_no')->nullable();
			$table->string('po_no', 30)->nullable();
			$table->string('quote_no', 30)->nullable();
			$table->bigInteger('reseller')->nullable();
			$table->float('price', 10)->nullable();
			$table->decimal('warranty', 12, 10)->nullable();
			$table->string('date_purchased', 20)->nullable()->default('0000-00-00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('equipment_purchase');
	}

}
