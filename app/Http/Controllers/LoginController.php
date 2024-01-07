<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginpost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email Tidak Valid.',
            'password.required' => 'Kombinasi NIK dan Password Anda Salah, Silahkan Coba Lagi',
        ]);

        // $credentials = $request->only('nik', 'password');
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            // return redirect('/admin');
            return redirect('/shop');
            // $user = Auth::user();
            // // dd($user);
            // if ($user->roles == 'ADMIN') {
            //     return redirect('/admin');
            // } else {
            //     return redirect('/loginadmin')->withErrors('Login Anda Tidak Valid');
            // }
        } else {
            return redirect('/')->withErrors('Login Anda Tidak Valid');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success','Akun Anda Berhasil Dikeluarkan!');
    }
}
