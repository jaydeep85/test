<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
		return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];   

        if (Auth::attempt($credentials)) {
            
            return redirect()->route('welcome');
        }

        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }


    public function logout() 
    {
        Auth::logout();
        return redirect('/');
    }

}
