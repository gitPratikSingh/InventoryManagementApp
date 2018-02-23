<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groups extends Model
{
    protected $table = 'groups';

    public $timestamps = false;

    protected $dates = ['deleted_at'];
    
    use SoftDeletes;

    protected $softDelete = true;

    protected $fillable = [
      'name',
      'user_id',
      'parent'
    ];

    public function parent()
    {
        return $this->belongsTo(Groups::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Groups::class, 'parent');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'unit_id', 'id');
    }
}
