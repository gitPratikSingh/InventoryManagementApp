<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $table = 'units';

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