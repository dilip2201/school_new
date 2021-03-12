<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;

    public function uniforms(){
    	return $this->hasMany('App\Uniform','item_id','id');
    }
}
