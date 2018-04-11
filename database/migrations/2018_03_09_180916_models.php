<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Models extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('makes_id')->unsigned();
            $table->string('name', 50);
            $table->timestamp('deleted_at')->nullable(true);

           // $table->foreign('makes_id', 'foreign_key_models_make_id')->references('id')->on('makes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models');
    }
}
