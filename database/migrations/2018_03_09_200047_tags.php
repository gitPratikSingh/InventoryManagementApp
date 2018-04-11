<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('unit_id')->unsigned();

            $table->foreign('unit_id', 'foreign_key_tags_unit_id')->references('id')->on('units');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function(Blueprint $table)
		{
            $table->dropForeign('foreign_key_tags_unit_id');
        });
        
        Schema::dropIfExists('tags');
    }
}
