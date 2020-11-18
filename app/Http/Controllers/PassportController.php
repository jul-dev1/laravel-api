<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class PassportController extends Controller
{
    public function register(Request $request){
        $this->validate($request,[
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        $token = $user->createToken('My Token')->accessToken;
        return response()->json(['token'=>$token],200);
    }

    public function login(Request $request){
        $login=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login)){
            $token=auth()->user()->createToken('My Token')->accessToken;
            return response()->json(['token'=>$token],200);
        }else{
            return response()->json(['error'=>'UnnAuthorized'],401);
        }
    }

    public function user(){
        return response()->json(['token'=>auth()->user()],200);
    }
}
