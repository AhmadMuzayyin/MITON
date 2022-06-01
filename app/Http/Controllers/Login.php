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
                return redirect()->route('PAK')->with('success', 'Login Success!');
            } else {
                $request->session()->regenerate();
                return redirect()->route('PAK')->with('success', 'Login Success!');
            }
        }
        return back()->with('error', 'Login Error!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'See you next time!');
    }
}
