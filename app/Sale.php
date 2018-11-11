<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_user', 'sale_stayprice', 'sale_price','sale_cus','sale_cusphone'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','sale_user');
    }
    public function items()
    {
        return $this->belongsToMany('App\Item','salesitems','sale_id')->withPivot('item_mount');
    }
}
