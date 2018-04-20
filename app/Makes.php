<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Makes extends Model
{
    protected $table = 'makes';

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