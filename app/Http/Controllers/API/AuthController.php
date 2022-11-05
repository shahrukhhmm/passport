<?php

namespace App\Http\Controllers\API;

use Hash;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $req){
        $user = User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password)
        ]);
        $token=$user->createToken('Token')->accessToken;
        return response()->json(['token'=>$token,'user'=>$user],200);
    }

    public function login(Request $req){
        $data=[
            'email'=>$req->email,
            'password'=>$req->password
        ];
         if(auth()->attempt($data)){
            $token=auth()->user()->createToken('Token')->accessToken;
            return response()->json(['token'=>$token],200);

         }
         else{
        return response()->json(['error'=>'unauthorized'],401);

         }
    }

    public function userInfo(){
        $user=auth()->user();
        return response()->json(['user'=>$user],200);

    }
}
