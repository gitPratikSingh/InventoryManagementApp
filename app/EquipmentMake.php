<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentMake extends Model
{
    protected $table = 'equipment_make';

    public $timestamps = false;

    protected $fillable = [
      'name',
      'user_id',
    ];
}
