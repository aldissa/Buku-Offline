<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function postlogin(Request $request){
        $cek = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($cek)){
            $user = Auth::user();
            if($user->role =='admin'){
                return redirect()->route('index');
            } elseif($user->role =='kasir'){
                return redirect()->route('home');
            } else{
                return redirect()->route('home.owner');
            }
        }

        return back()->with('err','Username atau password salah');
    }

    function logout() {
        auth()->logout();
        return redirect()->route('login');
    }
}
