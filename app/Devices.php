<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devices extends Model
{
    protected $table = 'devices';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function makes()
    {
        return $this->belongsTo('App\Makes');
    }

    public function models()
    {
        return $this->belongsTo('App\Models');
    }

    public function units()
    {
        return $this->belongsTo('App\Units');
    }

    public function devicesPurchases()
    {
        return $this->belongsTo('App\DevicesPurchases');
    }
    
    public function getNameAttribute($value) {
        return ucfirst($value);
    }
    
}