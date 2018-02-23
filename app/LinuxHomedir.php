<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxHomedir extends Model
{
    protected $table = '_linux_homedir';

    public $timestamps = false;

    protected $fillable = [
      'unityID',
      'hostname',
      'updated_at',
    ];
}
