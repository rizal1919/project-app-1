<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KelasAdminController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\StudentController;
use App\Models\Kurikulum;
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




// route pendaftaran
Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->middleware('auth');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->middleware('auth');



// route kelas
Route::get('/kelas-admin', [KelasAdminController::class, 'index'])->middleware('auth');
Route::post('/kelas-admin', [KelasAdminController::class, 'index']);

Route::get('/kelas-admin/show/{program:id}', [KelasAdminController::class, 'show'])->middleware('auth');
Route::get('/kelas-admin/show/student/{student:id}', [KelasAdminController::class, 'showStudent'])->middleware('auth');
Route::get('/kelas-admin/update/student/{student:id}', [KelasAdminController::class, 'editStudent'])->middleware('auth');
Route::post('/kelas-admin/update/student/{student:id}', [KelasAdminController::class, 'updateStudent'])->middleware('auth');
Route::get('/kelas-admin/delete/student/{student:id}', [KelasAdminController::class, 'destroyStudent'])->middleware('auth');


// route data-siswa
Route::get('/data-siswa', [StudentController::class, 'index']);
Route::post('/data-siswa', [StudentController::class, 'index']);
Route::get('/data-siswa/show/student/{student:id}', [StudentController::class, 'show']);
Route::get('/data-siswa/update/student/{student:id}', [StudentController::class, 'edit']);
Route::post('/data-siswa/update/student/{student:id}', [StudentController::class, 'update']);
Route::get('/data-siswa/delete/student/{student:id}', [StudentController::class, 'destroy']);


// routes kurikulum
Route::get('/kurikulum', [KurikulumController::class, 'index'])->middleware('auth');
Route::get('/create-kurikulum', [KurikulumController::class, 'create'])->middleware('auth');
Route::post('/store-kurikulum', [KurikulumController::class, 'store']);
Route::get('/show/{kurikulum:id}', [KurikulumController::class, 'show']);
Route::get('/update/{kurikulum:id}', [KurikulumController::class, 'edit']);
Route::post('/update/{kurikulum:id}', [KurikulumController::class, 'update']);
Route::get('/delete-kurikulum/{kurikulum:id}', [KurikulumController::class, 'destroy']);


// routes program
Route::get('/program/{kurikulum:id}', [ProgramController::class, 'index'])->Middleware('auth');

Route::get('/show/{program:nama_program}', [ProgramController::class, 'show']);

Route::get('/create/{kurikulum:id}', [ProgramController::class, 'create'])->Middleware('auth');
Route::post('/create', [ProgramController::class, 'store']);

Route::get('/update-program/{program:id}', [ProgramController::class, 'edit'])->Middleware('auth');
Route::post('/update-program/{program:id}', [ProgramController::class, 'update']);

Route::get('/delete-program/{program:id}', [ProgramController::class, 'destroy'])->Middleware('auth');

// routes materi
// Route::get('/materi', [MateriController::class, 'index']);
// Route::get('/materi/{materi:program_id}', [MateriController::class, 'indexMateri']);
Route::get('/materi/{program:id}', [ProgramController::class, 'indexMateri'])->Middleware('auth');

Route::get('/create-materi/{program:id}', [MateriController::class, 'createMateri'])->Middleware('auth');
Route::post('/create-materi', [MateriController::class, 'storeMateri']);

Route::get('/show-materi/{materi:id}', [MateriController::class, 'showMateri'])->Middleware('auth');

Route::get('/update-materi/{materi:id}', [MateriController::class, 'editMateri'])->Middleware('auth');
Route::post('/update-materi/{materi:id}', [MateriController::class, 'updateMateri']);

Route::get('/delete-materi/{materi:id}', [MateriController::class, 'destroyMateri'])->Middleware('auth');





