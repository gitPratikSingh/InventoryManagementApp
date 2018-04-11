<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->primary(['role_id', 'permission_id']);
            $table->timestamp('deleted_at')->nullable(true);
            
            $table->foreign('role_id', 'foreign_key_roles_permissions_role_id')->references('id')->on('roles');
            $table->foreign('permission_id', 'foreign_key_roles_permissions_permission_id')->references('id')->on('permissions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles_permissions', function(Blueprint $table)
		{   
            $table->dropForeign('foreign_key_roles_permissions_role_id');
            $table->dropForeign('foreign_key_roles_permissions_permission_id');
        });
        
        Schema::dropIfExists('roles_permissions');
    }
}
