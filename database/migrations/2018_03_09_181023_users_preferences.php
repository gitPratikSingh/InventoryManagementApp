<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersPreferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_preferences', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('route', 50);
            $table->string('type', 20);
            $table->string('preferences', 256);
            $table->primary(['user_id', 'route', 'type']);
            $table->timestamp('deleted_at')->nullable(true);
            
            $table->foreign('user_id', 'foreign_key_users_preferences_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_preferences', function(Blueprint $table)
		{   
            $table->dropForeign('foreign_key_users_preferences_user_id');
        });

        Schema::dropIfExists('users_preferences');
    }
}
