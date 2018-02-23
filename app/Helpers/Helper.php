<?php 

namespace App\Helpers;

use App\Groups;
use \stdClass;

class Helper
{

    public static function getMyGroups($UnitId)
    {
        $myGroups = Groups::selectRaw('GROUP_CONCAT(id)')->where('parent', $UnitId)->get()->toArray();
        return $myGroups[0]['GROUP_CONCAT(id)'];
    }

    public static function myGroups($Id)
    {
        $groups = Groups::find((int)$Id);
        $childern = $groups->children()->get();
      	$debug = false;

        $myGpList = new StdClass();
        $myGpList->$Id = $Id;
        foreach($childern as $child){
        	if($debug) echo "<br>--1->".$child->name;
        	$myGpList->{$child->id} = $child->id;
        	$grandChildern = $child->children()->get();
        	foreach($grandChildern as $grandChild){
        		if($debug) echo "<br>----2->".$grandChild->name;
        		$myGpList->{$grandChild->id} = $grandChild->id;
        		$grandGrandChildern = $grandChild->children()->get();
	        	foreach($grandGrandChildern as $grandGrandChild){
	        		if($debug) echo "<br>------3->".$grandGrandChild->name;
	        		$myGpList->{$grandGrandChild->id} = $grandGrandChild->id;
	        		foreach($grandGrandChild as $grandGrandGrandChild){
	        			if(is_object($grandGrandGrandChild)){
		        			if($debug) echo "<br>--------4->".$grandGrandGrandChild->name;
		        			$myGpList->{$grandGrandGrandChild->id} = $grandGrandGrandChild->id;
		        		}
		        	}
	        	}
        	}
        }

        
       	$groupsList = implode(',', (array)$myGpList);
       	return $groupsList;

    }


}