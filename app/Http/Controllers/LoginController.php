<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){

        return view('Login.index', [

            'title' => 'Login | ',
            'active' => 'Login'
        ]);
    }

    public function authenticate(Request $request){

        $credentials = $request->validate([

            'username_admin' => "required|between:5,255|alpha",
            'password' => "required"
        ]);

        // dd($credentials);
        // dd(Auth::attempt($credentials));

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login Gagal! ');
        
    }

    public function logout(Request $request)
    {

        // dd($request);

        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }

    // public function logout(Request $request) {
    //     $accessToken = auth()->user()->token();
    //     $token= $request->user()->tokens->find($accessToken);
    //     $token->revoke();
    //     return redirect('/login-admin-baru');
    // }
}
