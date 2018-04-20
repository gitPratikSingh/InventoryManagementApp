<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DevicesPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            $table->string('vendor', 50);
            $table->string('account', 50);
            $table->string('quote_number', 50);
            $table->string('order_number', 50);
            $table->string('price', 50);
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('device_id', 'foreign_key_devices_purchases_device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices_purchases', function(Blueprint $table)
		{
            $table->dropForeign('foreign_key_devices_purchases_device_id');
        });

        Schema::dropIfExists('devices_purchases');
    }
}
