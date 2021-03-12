<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandardStrength extends Model
{
    protected $table = 'standard_strength';
     protected $fillable = [
        'standard_id','total','boys','girls'
    ];
   public $timestamps = false;
}
