<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCOntroller extends Controller
{
    // Admin page
    public function dashboard()
    {
        return view('admin.dashboard');
    }


}
