<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    // login logic
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        // debug the password
        // $user = User::where('email', $request->email)->first();
        // dd($user->password);

        // if (Hash::check($request->password, $user->password)) {
        //     dd('Password matches');
        // } else {
        //     dd('Password does not match');
        // }

        // if the user is exist in the database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'You are logged in');
        }

        // if the user is not exist in the database
        return redirect(route('login'))->with('error', 'Incorrect email or password.');
    }

    public function signupPost(Request $request)
    {
        // no password validation
        // $request->validate([
        //     'FName' => 'required',
        //     'LName' => 'required',
        //     'Email' => 'required|email|unique:users',
        //     'Password' => 'required',
        //     'CPassword' => 'required|same:Password',
        // ], [
        //     'FName.required' => 'Please enter your first name.',
        //     'LName.required' => 'Please enter your last name.',
        //     'Email.required' => 'Please enter your email address.',
        //     'Email.email' => 'Please enter a valid email address.',
        //     'Email.unique' => 'This email address is already taken.',
        //     'Password.required' => 'A password is required.',
        //     'CPassword.required' => 'Please confirm your password.',
        //     'CPassword.same' => 'The confirmation password does not match the password.',
        // ]);

        // Password validation
        $request->validate([
            'FName' => 'required',
            'LName' => 'required',
            'Email' => 'required|email|unique:users',
            'Password' => [
                'required',
                'string',
                'min:8', // At least 8 characters
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one digit
                'regex:/[@$!%*?&#]/' // At least one special character
            ],
            'CPassword' => 'required|same:Password',
        ], [
            'FName.required' => 'Please enter your first name.',
            'LName.required' => 'Please enter your last name.',
            'Email.required' => 'Please enter your email address.',
            'Email.email' => 'Please enter a valid email address.',
            'Email.unique' => 'This email address is already taken.',
            'Password.required' => 'A password is required.',
            'Password.min' => 'Password must be at least 8 characters long.',
            'Password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            'CPassword.required' => 'Please confirm your password.',
            'CPassword.same' => 'The confirmation password does not match the password.',
        ]);

        $data = [
            'first_name' => ucwords($request->FName),
            'last_name' => ucwords($request->LName),
            'email' => $request->Email,
            'password' => Hash::make($request->Password),  // hash the password
            'role' => 'student',
        ];

        // dd($data['password']);  // This will output the hashed password to check its correctness

        $user = User::create($data);

        if (!$user) {
            return redirect(route('signup'))->with('error', 'Something went wrong. Please try again.');
        }

        return redirect(route('login'))->with('success', 'You are registered successfully!');
    }

    function logout()
    {
        // $request->session()->flush();
        Session::flush();
        Auth::logout();
        return redirect(route('welcome'));
    }
}
