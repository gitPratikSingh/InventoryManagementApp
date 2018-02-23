<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinuxUsersSudo extends Model
{
    protected $table = '_linux_users_sudo';

    public $timestamps = false;

    protected $fillable = [
      'unityID',
      'hostname',
      'perms',
      'updated_at',
    ];
}
