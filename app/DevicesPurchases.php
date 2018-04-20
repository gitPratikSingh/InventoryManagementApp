<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevicesPurchases extends Model
{
    protected $table = 'devices_purchases';

    /**
     * Always capitalize the first name when we retrieve it
     */
    public function getFirstNameAttribute($value) {
        return ucfirst($value);
    }

    public function devices()
    {
        return $this->hasMany('App\Devices');
    }
}