<?php

namespace App\Http\Controllers\API;

use App\Item;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Buy;
class BuyController extends Controller
{
    public function index()
    {
        $buys= Buy::with('items','user')->orderBy('id','DESC')->paginate(10);
        return $buys;
    }
    public function store(Request $request)
    {
        $buy = Buy::create([
            'buy_user'=>$request->buy_user,
            'buy_stayprice'=>$request->buy_stayprice,
            'buy_price'=>$request->buy_price,
            'buy_sub'=>$request->buy_sub,
            'buy_subphone'=>$request->buy_subphone
        ]);
        $buyid =$buy->id;
        $itme =Input::post('item');
        $mount = Input::post('mount');
        foreach(array_combine($itme, $mount) as $d1 => $d2)
        {
            $buy->items()->attach($buyid,[
                'item_id' => $d1,
                'item_mountbuy' => $d2
            ]);
        }
        $buyy = Buy::with('items','user')->find($buyid);

        return view('buyprint')->with('buyy',$buyy);
    }
    public function show($id)
    {
        $buy = Buy::with('items','user')->find($id);

        return $buy;
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
