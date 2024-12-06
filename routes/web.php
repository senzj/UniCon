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
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\FileDownloadController;

//  ================================================================| Notes |===========================================================================
// name serve as identifier for the route like ID
//Route::get('URI', [ControllerName::class, 'MethodName'])->name('routeName that serves as identifier'); (routing to controller format)
// =====================================================================================================================================================

// Routes
// Route::method('uri', [Controller::class, 'method'])->name('route.name');

// usage 
// Route::get('/home', [HomeController::class, 'index'])->name('home'); // in routes page
// <a href="{{ route('home') }}">Go to Home</a> // in any views page

// route for auth

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
Route::get('/signup', [AuthController::class, 'showSignup'])
->name('signup')->middleware('guest');
Route::post('/signup', [AuthController::class, 'signupPost'])
->name('signup@post');


// logged in users pages view
//lougout
Route::get('/logout', [AuthController::class, 'logout'])
->name('logout')->middleware('auth');

// custom middleware routes are located in bootstrap/app.php
// Admin page
Route::get('/admin', [AdminController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware(['auth', 'admin']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
->name('admin.dashboard');
Route::put('/admin/update-role/{id}', [AdminController::class, 'updateRole'])
->name('updateRole');

//teacher page
Route::get('/teacher', [TeacherController::class, 'index'])
    ->name('teacher')
    ->middleware(['auth', 'teacher']);

    //route to create a new group chat
    Route::middleware(['auth'])->group(function () {
        Route::post('/teacher/creategroup', [TeacherController::class, 'createGroupChat'])
        ->name('teacher@createGroup');
    });

    // route to get the content of the selected group chat ID
    Route::get('/teacher/chat/{id}', [TeacherController::class, 'getMessage'])
    ->name('get.message');

    // route to send a message to a group chat
    Route::post('/teacher/sendmessage/{ID}', [TeacherController::class, 'sendMessage'])
    ->name('send.message');

    // route to add a member
    Route::post('/addgroupmember', [TeacherController::class, 'addMember'])
    ->name('teacher.addMember');

//student page
Route::get('/student', [Controller::class, 'student'])
    ->name('student')
    ->middleware(['auth', 'student']);
    Route::post('/groupchats/{groupId}/add-member', [TeacherController::class, 'addMember']);
Route::get('/home', [TeacherController::class, 'showHome'])->name('teacher.home');


// file download route
Route::get('/download/file/{filename}', [FileDownloadController::class, 'download'])
    ->where('filename', '.*')  // Allow full path with slashes
    ->name('file.download');

//file upload page
// Route::get('/upload',[FileController::class,'showUpload'])->name('upload')->middleware('auth');
// Route::post('/upload',[FileController::class,'upload'])->name('upload@post')->middleware('auth');
