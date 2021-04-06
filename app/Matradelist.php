<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matradelist extends Model
{
        protected $fillable = [
        'trade_id', 'type', 'price'
    ];

     public $timestamps = false;
}
