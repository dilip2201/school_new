<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PO extends Model
{


    public function vendor() {
        return $this->belongsTo('App\Vendor','vendor_id','id');
    }

    public function items() {
        return $this->belongsToMany('App\ItemMaster','p_o_items','po_id','item_id');
    }
}
