<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentComputer extends Model
{
	public $timestamps = false;
    protected $table = 'equipment_computer';
    protected $guareded = [
    	'id',
    	'equipment_id'
    ];
    protected $fillable = [
    	'memory',
    	'processor',
    	'harddrive',
    	'os_id',
    	'os_version',
    	'ip',
    	'domain_id',
    	'ethernet',
		'hostname'
    ];

		public function os()
    {
        return $this->hasOne(Os::class, 'id' ,'os_id');
    }

    public function parts()
    {
        return $this->hasMany(EquipmentComputerParts::class, 'computer_id');
    }
}
