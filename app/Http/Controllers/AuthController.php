<?php

namespace App\Http\Controllers;

use Validator; //for validate import
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

        // if the user is exist in the database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        
            // Redirect based on user role
            $user = Auth::user();
        
            switch ($user->role) {
                // Admin route
                case 'admin':
                    return redirect()->route('dashboard')->with('success', "Wecome to Admin dashboard!");

                // Teacher route
                case 'teacher':
                    return redirect()->route('teacher')->with('success', "Welcome to Teacher dashboard!");

                // Student route;
                case 'student':
                    return redirect()->route('student')->with('success', "Welcome to Student dashboard!");

                // Undefined roles 
                default:
                    
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Invalid role!');
            }
        }

        // if the user is not exist in the database
        return redirect(route('login'))->with('error', 'Incorrect Email or Password.');
    }

    public function signupPost(Request $request)
    {
        // Password validation
        $request->validate([
            'FName' => 'required',
            'LName' => 'required',
            'Email' => [
                'required',
                'email',
                'unique:users',
                'max:255'
            ],
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
            return back()->with('error', 'Something went wrong. Please try again.');
        }

        return redirect(route('login'))->with('success', 'Registered successfully!');
    }

    function logout()
    {
        // $request->session()->flush();
        Session::flush();
        Auth::logout();
        return redirect(route('home'))->with("success", "Successfully logged out!");
    }
}
