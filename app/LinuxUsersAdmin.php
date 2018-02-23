<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxUsersAdmin extends Model
{
    protected $table = '_linux_users_admin';

    public $timestamps = false;

    protected $fillable = [
      'unityID',
      'hostname',
      'updated_at',
    ];
}
