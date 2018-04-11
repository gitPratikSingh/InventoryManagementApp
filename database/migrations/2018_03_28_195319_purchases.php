<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Purchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_purchases', function (Blueprint $table) {
            $table->integer('device_id')->unsigned();
            $table->string('vendor', 100)->nullable();
            $table->string('account', 100)->nullable();
            $table->string('quote_number', 100)->nullable();
            $table->string('order_number', 100)->nullable();
            $table->string('price', 100)->nullable();
            $table->date('date_purchased', 100)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices_purchases');
    }
}
