<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    protected $table = 'item_masters';
    protected $fillable = [
        'name','ract_number','item_id'
    ];
    public $timestamps = false;

    public function itemname() {
        return $this->belongsTo('App\Item','item_id','id');
    }
}
