<?php

namespace App\Http\Controllers;

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
