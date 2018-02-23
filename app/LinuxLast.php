<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxLast extends Model
{
    protected $table = '_linux_last';

    public $timestamps = true;

    protected $fillable = [
      'logout_datetime',
      'updated_at',
      'cretaed_at',
    ];
}
