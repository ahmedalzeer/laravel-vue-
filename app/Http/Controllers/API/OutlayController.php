<?php

namespace App\Http\Controllers\API;

use App\Outlay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OutlayController extends Controller
{
    public function index()
    {
        return Outlay::latest()->paginate(10);
    }
    public function store(Request $request)
    {
       $this->validate($request,[
           'outlay_name'=>'required|min:3',
           'outlay_mount'=>'required'
       ]);
       Outlay::create([
           'outlay_name'=>$request->outlay_name,
           'outlay_mount'=>$request->outlay_mount
       ]);
       return ['message'=>'created successfully'];
    }
    public function show($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'outlay_name'=>'required|min:3',
            'outlay_mount'=>'required'
        ]);
        $out = Outlay::findOrFail($id);
        $out->update($request->all());
        return ['message'=>'updated successfully'];
    }
    public function destroy($id)
    {
        $out = Outlay::findOrFail($id);
        $out->delete();
        return ['message'=>'deleted successfully'];
    }
}
