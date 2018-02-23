<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Os extends Model
{
    protected $table = 'os';

    public $timestamps = false;

    protected $fillable = [
      'name',
      'user_id',
    ];
}
