<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxDiskusage extends Model
{
    protected $table = '_diskusage';

    public $timestamps = false;

    protected $fillable = [
      'unityID',
      'mounted_on',
      'filesystem',
      'type',
      'used',
      'available',
      'percent',
      'hostname',
      'updated_at',
    ];
}
