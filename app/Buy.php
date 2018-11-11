<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    protected  $fillable = [
        'buy_user','buy_stayprice','buy_price','buy_sub','buy_subphone'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','buy_user');
    }
    public function items()
    {
        return $this->belongsToMany('App\Item','buysitems','buy_id')->withPivot('item_mountbuy');
    }
}
