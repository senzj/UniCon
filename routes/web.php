<?php
// Import
// Import the Route class
use Illuminate\Support\Facades\Route;

// Import the Custom Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;

//  ================================================================| Notes |===========================================================================
// name serve as identifier for the route like ID
//Route::get('URI', [ControllerName::class, 'MethodName'])->name('routeName that serves as identifier'); (routing to controller format)
// =====================================================================================================================================================

// Routes

// not logged in users pages
// home page (default page)
Route::get('/', function () {
    return view('contents.home');
})->name('home') // this route is named 'home'
    //->middleware('auth'); //only authenticated users can access this route(logged in users)
    ->middleware('guest'); //only guest users can access this route(logged in users)

// Login page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login@post');

// Signup page
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup')->middleware('guest');
Route::post('/signup', [AuthController::class, 'signupPost'])->name('signup@post');


// logged in users pages view
//lougout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// custom middleware routes are located in bootstrap/app.php
// Admin page
Route::get('/admin', [AdminController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware(['auth', 'admin']);

//teacher page
Route::get('/teacher', [Controller::class, 'teacher'])
    ->name('teacher')
    ->middleware(['auth', 'teacher']);

//student page
Route::get('/student', [Controller::class, 'student'])
    ->name('student')
    ->middleware(['auth', 'student']);


//file upload page
// Route::get('/upload',[FileController::class,'showUpload'])->name('upload')->middleware('auth');
// Route::post('/upload',[FileController::class,'upload'])->name('upload@post')->middleware('auth');
