<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'files';

    public $timestamps = true;

    protected $fillable = [
      'host',
      'data',
      'type',
    ];
}
