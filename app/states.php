<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class states extends Model
{
    protected $table = 'states';
    
    public function country() {
        return $this->belongsTo('App\Country','country_id','id');
    }
}

