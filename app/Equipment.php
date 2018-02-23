<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $guareded = [
    	'id',
    	'created_at',
    	'updated_at',
    ];

    protected $fillable = [
    	'equipment_name',
    	'type_id',
    	'serial_number',
    	'cams',
    	'make_id',
    	'model_id',
      'model',
    	'building_id',
    	'room',
    	'owner',
      'primary_user',
      'unit_id',
    	'group_id',
    	'warranty',
      'personal',
      'offsite',
    ];


    public function computers()
    {
        return $this->hasOne(EquipmentComputer::class);
    }

    public function purchases()
    {
        return $this->hasOne(EquipmentPurchase::class);
    }

    public function notes()
    {
        return $this->hasMany(Notes::class);
    }


}
