<?php

namespace App\Http\Controllers;

// this controller is only serves as redirector to the home page of other pages
class Controller
{
    // route controller for teachers home page
    public function teacher()
    {
        return view('teacher.home');
    }

    // route controller for students home page
    public function student()
    {
        return view('student.home');
    }

}
