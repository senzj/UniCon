<?php

use Illuminate\Support\Facades\Route;

// home page (default page)
Route::get('/', function () {
    return view('home');
});

// login page page
Route::get('/login', function () {
    return view('auth/login');
});

// signup page
Route::get('/signup', function () {
    return view('auth/signup');
});