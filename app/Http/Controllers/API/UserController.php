<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Intervention\Image;
use File;

class UserController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:api');
    }
    public function index()
    {
//        $this->authorize('isadmin');
        if(\Gate::allows('isadmin') || \Gate::allows('isauthor'))
        {
            return User::latest()->paginate(10);
        }
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|string|min:3',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:6',
            'bio'=>'min:3',
            'photo'=>'',
        ]);
        return User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'bio'=>$request->bio,
            'role'=>$request->role,
            'photo'=>$request->photo
        ]);
    }
    public function updateprofile(Request $request)
    {
        $user = auth('api')->user();
        $this->validate($request,[
            'name'=>'required|string|min:3',
            'email'=>'required|string|email|unique:users,email,'.$user->id,
            'password'=>'sometimes|required|string|min:6',
            'bio'=>'sometimes|min:3',
            'photo'=>'',
        ]);
        $currant = $user->photo;
        if($request->photo != $currant )
        {
            $name = time().'.'.explode('/',explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo'=>$name]);
        }
        if(!empty($request->password))
        {
            $request->merge(['password'=>bcrypt($request->password)]);
            $oldphoto = public_path('img/profile/').$currant;
            if(file_exists($oldphoto))
            {
                \File::delete($oldphoto);
            }
        }
        $user->update($request->all());
        return['message'=>'updateprofile'];
    }
    public function profile()
    {
        return auth('api')->user();
    }
    public function search()
    {
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('email','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $users = User::latest()->paginate(10);
        }
        return $users;
    }
    public function show($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request,[
            'name'=>'required|string|min:3',
            'email'=>'required|string|email|unique:users,email,'.$user->id,
            'password'=>'sometimes|required|string|min:6',
            'bio'=>'min:3',
            'photo'=>'',
        ]);
        $user->update($request->all());
        return ['message'=>'user updated'];
    }
    public function destroy($id)
    {
        $this->authorize('isadmin');
        $user = User::findOrFail($id);
        $user->delete();
        return['message'=>'user deleted successfully'];
    }
}
