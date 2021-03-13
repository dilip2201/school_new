<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
   	protected $fillable = [
        'name','image','email','county_code','phone'
    ];
}
