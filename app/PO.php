<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PO extends Model
{


    public function vendor() {
        return $this->belongsTo('App\Vendor','vendor_id','id');
    }
}
