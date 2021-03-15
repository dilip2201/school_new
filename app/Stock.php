<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    public function item() {
        return $this->belongsTo('App\ItemMaster','item_id','id');
    }
    public function itemsize() {
        return $this->belongsTo('App\Size','size','id');
    }
    public function vendor() {
        return $this->belongsTo('App\Vendor','vendor_id','id');
    }
}
