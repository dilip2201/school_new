<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PO extends Model
{
	protected $fillable = [
        'date','vendor_id','po_number','po_last_count','status','send_count'
    ];

    public function vendor() {
        return $this->belongsTo('App\Vendor','vendor_id','id');
    }

    public function stocks() {
        return $this->belongsToMany('App\Stock','p_o_items','po_id','item_id');
    }
}
