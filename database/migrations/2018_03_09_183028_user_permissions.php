<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->timestamp('deleted_at')->nullable(true);
            
            $table->primary(['user_id', 'permission_id', 'unit_id']);
            $table->foreign('permission_id', 'foreign_key_users_permissions_role_id')->references('id')->on('permissions');
            $table->foreign('user_id', 'foreign_key_users_permissions_user_id')->references('id')->on('users');
            $table->foreign('unit_id', 'foreign_key_users_permissions_unit_id')->references('id')->on('units');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_permissions', function(Blueprint $table)
		{
            $table->dropForeign('foreign_key_users_permissions_role_id');
            $table->dropForeign('foreign_key_users_permissions_user_id');
            $table->dropForeign('foreign_key_users_permissions_unit_id');
            
        });

        
        Schema::dropIfExists('users_permissions');
    }
}
