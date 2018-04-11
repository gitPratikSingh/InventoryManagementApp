<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('unity_id', 20);
            $table->string('email', 50);
            $table->timestamp('deleted_at')->nullable(true);
            
            $table->index('unity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
