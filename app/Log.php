<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
   	protected $fillable = [
        'stock_id','status','old_qty','new_qty','remarks'
    ];
}
