<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxUsersLocal extends Model
{
    protected $table = '_linux_users_local';

    public $timestamps = false;

    protected $fillable = [
      'unityID',
      'hostname',
      'updated_at',
    ];
}
