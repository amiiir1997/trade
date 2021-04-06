<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Macdrobot extends Model
{
    protected $fillable = [
        'small', 'big', 'intervall','symbol','position','coin','dollar','signal','limit','smoothing','closetime','state'
    ];
    public $timestamps = false;
}
