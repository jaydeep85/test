<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\ResetsPasswords;
use DB;
use App\Models\Student;
use Hash;


class ResetPasswordController extends Controller
{
        public function getPassword($token) {

        $getEmail = DB::table('password_resets')->select('email')->where('token',$token)->first();

        $emailVal = '';
        if(!empty($getEmail))
        {
            $emailVal = $getEmail->email;
        } 
       return view('auth.reset', ['token' => $token, 'email' => $emailVal]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',

        ]);

        $updatePassword = DB::table('password_resets')
                            ->where(['email' => $request->email, 'token' => $request->token])
                            ->first();

        if(!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

          $student = Student::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();

          return redirect()->route('login')->with('message', 'Your password has been changed!');
    }
}
