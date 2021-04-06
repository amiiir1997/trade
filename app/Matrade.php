<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matrade extends Model
{
    protected $fillable = [
        'small', 'big', 'intervall','symbol','position','coin','dollar','triger'
    ];

    public $timestamps = false;
}
