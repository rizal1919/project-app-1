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

            'username' => "required",
            'password' => "required"
        ]);

        if (Auth::guard('administrator')->attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/dashboard');
        }

        if(Auth::guard('teacher')->attempt($credentials)){

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login Gagal! ');
        
    }

    public function logout(Request $request)
    {

        

        Auth::guard('administrator')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->with('logoutSuccess', 'Logout berhasil!');
    }

}
