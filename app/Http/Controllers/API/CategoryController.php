<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::latest()->paginate(10);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
           'cat_name'=>'required|min:3|unique:categories',
        ]);
        return Category::create($request->all());
    }
    public function show($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
       $cat = Category::findOrFail($id);
        $this->validate($request,[
            'cat_name'=>'required|min:3|unique:categories,cat_name,'.$cat->cat_id
        ]);
        $cat->update($request->all());
        return ['message'=>'cat updated'];
    }
    public function destroy($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return ['message'=>'cat deleted'];
    }
}
