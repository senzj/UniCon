<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.home');
    }
    public function uploadProfile(Request $request)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Save the image to the 'public/profile-images' directory
    $filePath = $request->file('profile_image')->store('profile-images', 'public');

    // Save the image path to the session or database (example)
    session(['profileImage' => $filePath]);

    return back()->with('success', 'Profile image uploaded successfully!');
}
public function dashboard()
{
    // Pass the session-stored profile image to the view
    return view('home', ['profileImage' => session('profileImage')]);
}

}
