<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DevicesDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_details', function (Blueprint $table) {
            $table->integer('device_id')->unsigned();
            $table->string('category', 50);
            $table->string('component', 100);
            $table->text('data')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('device_id', 'foreign_key_devices_details_device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices_details', function(Blueprint $table)
		{
            $table->dropForeign('foreign_key_devices_details_device_id');
        });

        Schema::dropIfExists('devices_details');
    }
}
