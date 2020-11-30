<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use DB;
use Mail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    public function getEmail()
    {
       return view('auth.getemail');
    }

    public function postEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:students',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => date('Y-m-d H:i:s')]
        );

        Mail::send('auth.verify',['token' => $token], function($message) use ($request) {
                  $message->from('student@gmail.com');
                  $message->to($request->email);
                  $message->subject('Reset Password Notification');
               });

        return back()->with('message', 'Please check your e-mail for password reset link!');
    }

}
