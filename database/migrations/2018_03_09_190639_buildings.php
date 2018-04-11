<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Buildings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->string('name', 50);
            $table->string('address', 100);
            $table->string('city', 50);
            $table->string('zip', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
