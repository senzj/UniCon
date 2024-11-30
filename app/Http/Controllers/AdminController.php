<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch all users
        $users = User::all();
        return view('admin.dashboard', compact('users'));

    }

    public function updateRole(Request $request, $id)
    {
        // Validate the role input
        $request->validate([
            'role' => 'required|in:student,teacher',
        ]);

        // Update the user's role
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully!');
    }
}
