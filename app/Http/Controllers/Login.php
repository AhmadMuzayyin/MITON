<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $cek = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($cek)) {
            if (auth()->user()->isAdmin == 1) {
                $request->session()->regenerate();
                toastr()->success('Login Berhasil');
                return redirect()->route('PAK');
            } else {
                $request->session()->regenerate();
                toastr()->success('Login Berhasil');
                return redirect()->route('PAK');
            }
        }
        toastr()->error('Login gagal!');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        toastr()->success('See you next time!');
        return redirect('/');
    }
}
