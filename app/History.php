<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    public $timestamps = false;

    protected $fillable = [
    	'item_id',
    	'unit_id',
    	'user_id',
    	'screen',
    	'field',
    	'action',
    	'value_old',
    	'value_new'
    ];


    public function saveChanges($original, $changes, $userData, $screen, $action){

    	foreach($changes as $Key=>$Value):
    		Self::create([
	    		"item_id" 	=> $original['id'],
	    		"unit_id" 	=> $userData['unit_id'],
	    		"user_id" 	=> $userData['id'],
	    		"screen" 	  => $screen,
	    		"field" 	  => $Key,
	    		"action" 	  => $action,
	    		"value_old" => $original[$Key],
	    		"value_new" => $Value,
    		]);
    	endforeach;
    }

    public function insertChanges($itemID, $userData, $screen, $action){

    		Self::create([
	    		"item_id" 	=> $itemID,
	    		"unit_id" 	=> $userData['unit_id'],
	    		"user_id" 	=> $userData['id'],
	    		"screen" 	  => $screen,
	    		"action" 	  => $action,
    		]);

    }
}
