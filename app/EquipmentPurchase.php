<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentPurchase extends Model
{
    public $timestamps = false;
    protected $table = 'equipment_purchase';
    protected $guareded = [
      'id',
      'equipment_id'
    ];
    protected $fillable = [
      'acct_no',
      'po_no',
      'quote_no',
      'reseller',
      'price',
      'warranty',
      'date_purchased'
    ];
}
