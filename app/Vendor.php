<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
   	protected $fillable = [
        'name','image','email','county_code','phone','address','whatsapp_no','company_name','cp_name','cp_designation','cp_phone',
        'cp_whatsapp_no'
    ];
}
