<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Locations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('building_number', 50);
            $table->string('room_number', 50);

            #$table->foreign('building_id', 'foreign_key_locations_building_id')->references('id')->on('buildings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
          # $table->dropForeign('foreign_key_locations_building_id');
        });

        Schema::dropIfExists('locations');
    }
}
