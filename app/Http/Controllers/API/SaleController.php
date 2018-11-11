<?php

namespace App\Http\Controllers\API;

use App\Item;
use App\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items','user')->orderBy('id','DESC')->paginate(10);
//        return view('saleprint',compact('sales'));

        return $sales;
    }
    public function store(Request $request)
    {
        $sale = Sale::create([
            'sale_user'=>$request->sale_user,
            'sale_stayprice'=>$request->sale_stayprice,
            'sale_price'=>$request->sale_price,
            'sale_cus'=>$request->sale_cus,
            'sale_cusphone'=>$request->sale_cusphone
        ]);
        $saleid =$sale->id;
        $itme =Input::post('item');
        $mount = Input::post('mount');
        foreach(array_combine($itme, $mount) as $d1 => $d2)
        {
            $sale->items()->attach($saleid,[
                'item_id' => $d1,
                'item_mount' => $d2
            ]);
        }
        $sal = Sale::with('items','user')->find($saleid);

        return view('saleprint')->with('sal',$sal);
//        return $sal;
    }
    public function show($id)
    {
        $sal = Sale::with('items','user')->find($id);

        return $sal;
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
    public function mountitem(Request $request)
    {
        $search = \Request::post('ww');
        $item=Item::where(function ($query) use ($search){
                 $query->where('item_name','LIKE',"%$search%");
         })->get();
        return $item;
    }
    public function search()
    {
        if($search = \Request::get('q'))
        {
            $items = Item::where(function ($query) use ($search){
                $query->where('item_name','LIKE',"%$search%")
                    ->orWhere('item_desc','LIKE',"%$search%");
            })->paginate(5);
        }
        return $items;
    }
}
