<?php
// Import
// Import the Route class
use Illuminate\Support\Facades\Route;

// Import the AuthController
use App\Http\Controllers\AuthController;

// Notes
// name serve as identifier for the route like ID

// Routes
// welcome page
Route::get('/welcome', function () {
    return view('frontpage.welcome'); // this route returns the view 'frontpage(folder).welcome(file)'
})->name('welcome') // this route is named 'welcome'
    ->middleware('guest'); //only guests can access this route(not logged in users)

// about page
Route::get('/about', function () {
    return view('frontpage.about');
});

// home page (default page)
Route::get('/', function () {
    return view('home');
})->name('home') // this route is named 'home'
    ->middleware('auth'); //only authenticated users can access this route(logged in users)



//Route::get('URI', [ControllerName::class, 'MethodName'])->name('routeName that serves as identifier'); (routing to controller format)

// Login page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login@post');

// Signup page
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup')->middleware('guest');
Route::post('/signup', [AuthController::class, 'signupPost'])->name('signup@post');

//lougout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin page
// Route::get('/admin', [AdminController::class, 'admin'])->name('admin')->middleware('admin');
