<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentComputerParts extends Model
{
    protected $table = 'equipment_computer_parts';
    protected $guareded = [
    	'id', 
    	'computer_id' 
    ];
    protected $fillable = [
    	'part_type_id`', 
    	'make', 
    	'size',
    	'unit',
    ];
}
