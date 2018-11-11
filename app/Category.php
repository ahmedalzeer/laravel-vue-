<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $fillable = [
        'cat_name','cat_desc'
    ];
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
