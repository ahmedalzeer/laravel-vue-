<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected  $fillable = [
        'item_user','cat_id','item_name','item_desc','buy_price','sell_price','stay_mount','sell_mount','item_photo'
    ];
   public function category()
   {
       return $this->belongsTo('App\Category','cat_id');
   }
    public function user()
    {
        return $this->belongsTo('App\User','item_user');
    }
    public function sales()
    {
        return $this->belongsToMany('App\Sale','salesitems','item_id')->withPivot('item_mount');
    }
    public function buys()
    {
        return $this->belongsToMany('App\Buy','buysitems','item_id')->withPivot('item_mountbuy');
    }

}
