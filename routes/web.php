<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use GuzzleHttp\Middleware;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



// routes login
Route::get('/login-admin', [LoginController::class, 'index'])->name('login')->Middleware('guest');
Route::post('/login-admin', [LoginController::class, 'authenticate']);
Route::post('/logout-admin', [LoginController::class, 'logout']);


Route::get('/register-admin', [RegisterController::class, 'index'])->Middleware('guest');
Route::post('/register-admin', [RegisterController::class, 'store']);


// routes dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->Middleware('auth');



// routes program
Route::get('/program', [ProgramController::class, 'index']);
Route::post('/program', [ProgramController::class, 'index']);

Route::get('/show/{program:nama_program}', [ProgramController::class, 'show']);

Route::post('/create', [ProgramController::class, 'store']);
Route::get('/create', [ProgramController::class, 'create']);

Route::get('/update/{program}', [ProgramController::class, 'edit']);
Route::post('/update/{program}', [ProgramController::class, 'update']);

Route::get('/delete/{program}', [ProgramController::class, 'destroy']);

// routes materi
// Route::get('/materi', [MateriController::class, 'index']);
// Route::get('/materi/{materi:program_id}', [MateriController::class, 'indexMateri']);
Route::get('/materi/{program:id}', [ProgramController::class, 'indexMateri']);

Route::get('/create-materi/{program:id}', [MateriController::class, 'createMateri']);
Route::post('/create-materi', [MateriController::class, 'storeMateri']);

Route::get('/show-materi/{materi:id}', [MateriController::class, 'showMateri']);

Route::get('/update-materi/{materi:id}', [MateriController::class, 'editMateri']);
Route::post('/update-materi/{materi:id}', [MateriController::class, 'updateMateri']);

Route::get('/delete-materi/{materi:id}', [MateriController::class, 'destroyMateri']);





