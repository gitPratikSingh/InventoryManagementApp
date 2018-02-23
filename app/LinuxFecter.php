<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxFecter extends Model
{
    protected $table = '_linux_facter';

    public $timestamps = false;

    protected $fillable = [
      'unityID',
      'hostname',
      'updated_at',
    ];
}
