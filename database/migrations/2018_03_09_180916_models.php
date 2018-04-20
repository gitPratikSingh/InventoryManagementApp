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
            $table->integer('make_id')->unsigned()->nullable(true);
            $table->string('name', 50)->nullable(true) ;
            $table->timestamp('deleted_at')->nullable(true);

            $table->foreign('make_id', 'foreign_key_models_make_id')->references('id')->on('makes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('models', function(Blueprint $table)
		{
            $table->dropForeign('foreign_key_models_make_id');
        });

        Schema::dropIfExists('models');
    }
}
