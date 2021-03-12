<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uniform extends Model
{
    public function itemname(){
    	return $this->belongsTo('App\ItemMaster','single_text','id');
    }
}
