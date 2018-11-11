<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlay extends Model
{
    protected $fillable = [
        'outlay_name', 'outlay_mount'
    ];
}
