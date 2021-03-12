<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
	protected $table = 'schools';
   	protected $fillable = [
        'name','address','city_id','p_name','p_number','p_image','o_name','o_number','o_image'
    ];
    
    /********************************* City ***************************************/
    public function city()
    {
        return $this->belongsTo('App\City','city_id','id');
    }
    public function school()
    {
        return $this->belongsTo('App\School','school_id','id');
    }
}
