<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = 'notes';
    public $timestamps = false;

    protected $fillable = [
    	'equipmeny_id',
    	'note'
    ];
}
