<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUsers(){
       return response()->json(Users::all());
    }

    public function getUser($id){
        return response()->json(Users::where('id',$id)->firstOrFail());
    }

    public function createUser(Request $request){
        $v = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'role' => 'required|exists:roles,id'
        ]);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 400);
        }

        $user = new Users();

        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->patronymic = $request->patronymic;
        $user->role_id = $request->role;
        $user->save();

        return response()->json(['status'=> true,'user'=>$user]);

    }

    public function editUser($id, Request $request){
        $v = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 400);
        }
        $user = Users::find($id);

        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->patronymic = $request->patronymic;
        $user->role_id = $request->role_id;
        $user->save();

        $user = Users::find($id);
        return response()->json(['status'=> true,'user'=>$user]);
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return response()->json([],402);
    }
}
