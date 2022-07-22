<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;


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

Route::get('/program', [ProgramController::class, 'index']);

Route::get('/show/{program}', [ProgramController::class, 'show']);

Route::post('/create', [ProgramController::class, 'store']);
Route::get('/create', [ProgramController::class, 'create']);

Route::get('/update/{program}', [ProgramController::class, 'edit']);
Route::post('/update/{program}', [ProgramController::class, 'update']);

Route::post('/delete/{program}', [ProgramController::class, 'destroy']);
