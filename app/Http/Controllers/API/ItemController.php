<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Item;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);
        $items->load('user','category');
        return$items;
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'item_name'=>'required|min:2|unique:items',
            'sell_price'=>'|required',
            'buy_price'=>'|required',
            'cat_id'=>'|required',
        ]);

        $name = time().'.'.explode('/',explode(':',substr($request->item_photo,0,strpos($request->item_photo,';')))[1])[1];
        \Image::make($request->item_photo)->save(public_path('img/item/').$name);

        Item::create([
            'item_name'=>$request->item_name,
            'item_desc'=>$request->item_desc,
            'sell_price'=>$request->sell_price,
            'buy_price'=>$request->buy_price,
            'cat_id'=>$request->cat_id,
            'item_user'=>$request->item_user,
             'item_photo'=>$name

        ]);
        return ['message'=>'created successfully'];
    }
    public function show($id)
    {
        $item = Item::with('user','category')->find($id);
        return $item;
    }
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $this->validate($request,[
            'item_name'=>'required|min:2|unique:items,item_name,'.$item->id,
            'sell_price'=>'|required',
            'buy_price'=>'|required',
            'cat_id'=>'|required',
        ]);
        $currant = $item->item_photo;
        if($request->item_photo != $currant )
        {
            $name = time().'.'.explode('/',explode(':',substr($request->item_photo,0,strpos($request->item_photo,';')))[1])[1];
            \Image::make($request->item_photo)->save(public_path('img/item/').$name);
            $request->merge(['item_photo'=>$name]);
        }
        $oldphoto = public_path('img/item/').$currant;
        if(file_exists($oldphoto))
        {
            \File::delete($oldphoto);
        }
        $item->update($request->all());
        return ['message'=>'updated successfully'];
    }
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return ['message'=>'deleted successfully'];
    }
}
