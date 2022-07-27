<?php

namespace App\Http\Controllers;

use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){

        return view('Register.index', [
            'title' => 'Register | ',
            'active' => 'Login'
        ]);
    }

    public function store(Request $request){

        $credentials = $request->validate([

            'name_admin' => 'required|max:255',
            'username_admin' => 'required|between:5,255|alpha',
            'email' => 'required|email:dns|unique:user_admins',
            'password' => 'required'
        ],[

            'name_admin.required' => 'Nama admin belum terisi',
            'username_admin.required' => 'Pastikan nama anda sudah terisi',
            'username_admin.between' => 'Nama setidaknya terdiri dari 5-255 karakter',
            'username_admin.alpha' => 'Nama terdiri hanya huruf tanpa spasi',
            'email.required' => 'Pastikan email anda sudah terisi',
            'email.unique' => 'Email telah terdaftar, gunakan email lainnya',
            'email.email' => 'Isikan sesuatu nama berisikan seperti email@contoh.com',
            'password.required' => 'Password belum terisi'
        ]);

        $credentials['password'] = Hash::make($credentials['password']);
        // $validateData['password'] = Hash::make($validateData['password']);

        UserAdmin::create($credentials);

        return redirect('/login-admin')->with('success', 'Registrasi Berhasil! ');
        
    }
}
