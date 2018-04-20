<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DevicesOperatingSystems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_operating_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            $table->string('caption', 50)->nullable();
            $table->string('kernel', 50)->nullable();
            $table->string('version', 50)->nullable();
            $table->string('build', 50)->nullable();
            $table->string('service_pack', 50)->nullable();
            $table->timestamp('installed_at')->nullable();
            $table->timestamp('last_booted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('device_id', 'foreign_key_devices_operating_systems_device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices_operating_systems', function(Blueprint $table)
		{
            $table->dropForeign('foreign_key_devices_operating_systems_device_id');
        });

        Schema::dropIfExists('devices_operating_systems');
    }
}
