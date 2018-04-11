<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->text('note')->nullable();
            
            $table->foreign('created_by', 'foreign_key_notes_created_by')->references('id')->on('users');
            $table->foreign('device_id', 'foreign_key_notes_device')->references('id')->on('devices');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign('foreign_key_notes_created_by');
            $table->dropForeign('foreign_key_notes_device');
        });

        Schema::dropIfExists('notes');
    }
}
