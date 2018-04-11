<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->boolean('primary');
            $table->timestamp('deleted_at')->nullable(true);
            
            $table->primary(['user_id', 'role_id', 'unit_id']);
            $table->foreign('role_id', 'foreign_key_users_roles_role_id')->references('id')->on('roles');
            $table->foreign('user_id', 'foreign_key_users_roles_user_id')->references('id')->on('users');
            $table->foreign('unit_id', 'foreign_key_users_roles_unit_id')->references('id')->on('units');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {  
        Schema::table('users_roles', function(Blueprint $table)
		{  
            $table->dropForeign('foreign_key_users_roles_role_id');
            $table->dropForeign('foreign_key_users_roles_user_id');
            $table->dropForeign('foreign_key_users_roles_unit_id');
        });
        
        Schema::dropIfExists('users_roles');
    }
}
