<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commision extends Model
{
	protected $table = 'commisions';
   	protected $fillable = [
        'month','year','amount','remarks'
    ];
    public function school()
    {
        return $this->belongsTo('App\School','school_id','id');
    }
   
}
