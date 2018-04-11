<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DevicesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_types', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 50);
            $table->string('category', 50);
            $table->timestamp('deleted_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::dropIfExists('devices_types');
    }
}
