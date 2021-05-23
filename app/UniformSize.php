<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UniformSize extends Model
{
    protected $table = 'uniform_sizes';
    protected $fillable = [
        'item_id','size'
    ];

    public function sizeobj(){
    	return $this->hasMany('App\Stock','size','id');
    }
}
