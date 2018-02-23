<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oracle extends Model
{	
    protected $connection = 'mysql_oracle';
    protected $table = 'NC_ALLOUC_ENGVW';
}
