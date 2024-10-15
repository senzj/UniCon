<?php
// Import
// Import the Route class
use Illuminate\Support\Facades\Route;

// Import the AuthController
use App\Http\Controllers\AuthController;


// Routes
// home page (default page)
Route::get('/', function () {
    return view('home');
})->name('home');

// about page
Route::get('/about', function () {
    return view('about');
});

//Route::get('URI', [ControllerName::class, 'MethodName'])->name('routeName that serves as identifier'); (routing to controller format)

// Login page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

// Signup page
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signupPost'])->name('signup.post');

//lougout
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

