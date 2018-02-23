<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxUsersBase extends Model
{
    protected $table = '_linux_users_base';

    public $timestamps = false;

    protected $fillable = [
      'unityID',
      'hostname',
      'updated_at',
    ];
}
