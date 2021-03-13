<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    public function item() {
        return $this->belongsTo('App\Item','item_id','id');
    }
}
