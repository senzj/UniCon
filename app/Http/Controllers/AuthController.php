<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// for user model
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function showSignup(){
        return view('auth.signup');
    }

    // login logic
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Extract the credentials and map to the new structure
        // $credentials = [
        //     'email' => $data->input('Email'),
        //     'password' => $data->input('Password'),
        // ];
        $credentials = $data->only('email', 'password'); // this is the same as above, but no mapping is done
        
        // Debug the credentials being passed to Auth::attempt()
        dd($credentials);

        // check if the user exists in the database
        $auth = Auth::attempt($credentials);
        if ($auth) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'You are logged in');
        }

        // if the user is not exist in the database
        return redirect(route('login'))->with('error', 'Incorrect email or password.');
    }

    // signup logic
    public function signupPost(Request $request)
    {
        $request->validate([
            'FName' => 'required',
            'LName' => 'required',
            'Email' => 'required|email|unique:users',
            'Password' => 'required',
            'CPassword' => 'required|same:Password',
        ],
        [ // custom error messages
            'FName.required' => 'Please enter your first name.',
            'LName.required' => 'Please enter your last name.',
            'Email.required' => 'Please enter your email address.',
            'Email.email' => 'Please enter a valid email address.',
            'Email.unique' => 'This email address is already taken.',
            'Password.required' => 'A password is required.',
            'CPassword.required' => 'Please confirm your password.',
            'CPassword.same' => 'The confirmation password does not match the password.',
        ]);

        // Prepare data for user creation
        $data = [
            'first_name' => $request->FName,
            'last_name' => $request->LName,
            'email' => $request->Email,
            'password' => Hash::make($request->password),  // hash the password
            'role' => 'student',  // set a default role if needed
        ];

        // Debug the credentials being passed to Auth::attempt()
        // dd('debug', $data);

        // creates user
        $user = User::create($data);

        // if user is not created
        if (!$user){
            return redirect(route('signup'))->with('error', 'Something went wrong. Please try again.');
        } 
        // if user is created
        return redirect(route('login'))->with('success', 'You are registered successfully!');
    
    }

    function logout(){
        // $request->session()->flush();
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

}
