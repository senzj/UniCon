<?php
// Import
// Import the Route class
use Illuminate\Support\Facades\Route;

// Import the Custom Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;

//  ================================================================| Notes |===========================================================================
// name serve as identifier for the route like ID
//Route::get('URI', [ControllerName::class, 'MethodName'])->name('routeName that serves as identifier'); (routing to controller format)
// =====================================================================================================================================================

// Routes

// not logged in users pages
// events page
Route::get('/events', function () {
    return view('frontpage.events'); // this route returns the view 'frontpage(folder).welcome(file)'
})->name('events'); // this route is named 'welcome'

// news page
Route::get('/news', function () {
    return view('frontpage.news');
});

// Login page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login@post');

// Signup page
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup')->middleware('guest');
Route::post('/signup', [AuthController::class, 'signupPost'])->name('signup@post');


// logged in users pages view
// home page (default page)
Route::get('/', function () {
    return view('contents.home');
})->name('home') // this route is named 'home'
    ->middleware('auth'); //only authenticated users can access this route(logged in users)

//lougout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//publication page
Route::get('/publications', function () {
    return view('contents.publication');
})->name('publications')->middleware('auth');

// profile page


//file upload page
// Route::get('/upload',[FileController::class,'showUpload'])->name('upload')->middleware('auth');
// Route::post('/upload',[FileController::class,'upload'])->name('upload@post')->middleware('auth');

// Admin page
// Route::get('/admin', [AdminController::class, 'admin'])->name('admin')->middleware('admin');
