<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnChuKong extends Model
{
    //
    protected $fillable = [
        'date', 'week', 'doctor', 'status'
    ];
}
