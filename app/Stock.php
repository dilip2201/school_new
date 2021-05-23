<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'item_id','vendor_id','po_id','date','expected_date','size','quantity','pending_quantity','remark','status'
    ];
    public function item() {
        return $this->belongsTo('App\ItemMaster','item_id','id');
    }
    public function itemsize() {
        return $this->belongsTo('App\UniformSize','size','id');
    }
    public function vendor() {
        return $this->belongsTo('App\Vendor','vendor_id','id');
    }
    public function po() {
        return $this->belongsTo('App\PO','po_id','id');
    }
}
