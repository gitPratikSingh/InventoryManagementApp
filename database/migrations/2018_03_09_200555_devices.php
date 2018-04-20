<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Devices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->string('cams_tag', 50)->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('make_id')->unsigned()->nullable();
            $table->integer('model_id')->unsigned()->nullable();
            $table->integer('unit_id')->unsigned()->nullable();
            $table->string('owner', 100)->nullable();
            $table->string('user', 100)->nullable();
            $table->integer('building_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('type_id', 'foreign_key_devices_type_id')->references('id')->on('devices_types');
            $table->foreign('make_id', 'foreign_key_devices_make_id')->references('id')->on('makes');
            $table->foreign('model_id', 'foreign_key_devices_model_id')->references('id')->on('models');
            $table->foreign('location_id', 'foreign_key_devices_location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign('foreign_key_devices_make_id');
            $table->dropForeign('foreign_key_devices_model_id');
            $table->dropForeign('foreign_key_devices_type_id');
            #$table->dropForeign('foreign_key_devices_unit_id');
            $table->dropForeign('foreign_key_devices_location_id');
        });

        Schema::dropIfExists('devices');
    }
}
