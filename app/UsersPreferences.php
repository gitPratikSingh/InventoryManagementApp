<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;

class UsersPreferences extends Model
{   
    use HasCompositePrimaryKey;
    
    protected $table = 'users_preferences';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $primaryKey = array('user_id', 'route', 'type');

}