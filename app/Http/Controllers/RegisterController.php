<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
        'fname' => 'required|string|max:255',
        'lname' => 'required|string|max:255',
        'mname' => 'required|string|max:255',
        'mobile' => 'required|numeric|digits:10',
        'gender' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:students',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required',
        'photo' => 'required|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $profilePhoto = '';
        if($files = $request->file('photo'))
        {
            $destinationPath = '/photo';           
            $profilePhoto = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profilePhoto);
        }

        Student::create([
          'first_name' => $request->fname,
          'last_name' => $request->lname,
          'middle_name' => $request->mname,
          'gender' => $request->gender,
          'email' => $request->email,
          'mobile' => $request->mobile,
          'password' => Hash::make($request->password),
          'image' => $profilePhoto,
        ]);

        return redirect()->route('dashboard')->with('message', 'You are successfully registered');
    }

}
