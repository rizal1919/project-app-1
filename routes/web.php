<?php

use App\Http\Controllers\AktivasiController;
use App\Http\Controllers\AssignTeacherController;
use App\Http\Controllers\ClassroomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KelasAdminController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\PICController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\TeacherController;
use App\Models\AssignTeacher;
use App\Models\Classroom;
use App\Models\Kurikulum;
use App\Models\Pendaftaran;
use App\Models\Student;
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

// Route::get('/', function () {
//     return view('Home.index', [
//         'title' => 'Home | ',
//         'active' => 'Home'
//    ]);
// })->name('home')->middleware('guest');



// routes login
Route::get('/', [LoginController::class, 'index'])->name('login')->Middleware('guest');
Route::post('/login-admin', [LoginController::class, 'authenticate']);
Route::post('/logout-admin', [LoginController::class, 'logout']);


// routes dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->Middleware('auth');
Route::get('/export-pdf', [DashboardController::class, 'exportPDF'])->Middleware('auth');




// route pendaftaran 
Route::get('/form-registrasi', [PendaftaranController::class, 'index'])->middleware('auth');
Route::get('/form-registrasi/create', [PendaftaranController::class, 'create'])->middleware('auth');
Route::post('/form-registrasi/create', [PendaftaranController::class, 'store'])->middleware('auth');
Route::post('/form-registrasi-softdelete/{student_id}/{activation_id}', [PendaftaranController::class, 'softDeleteStudent'])->middleware('auth');
Route::get('/form-registrasi/getStudent', [PendaftaranController::class, 'getStudent'])->name('getStudent')->middleware('auth');
Route::get('/form-registrasi/getPayment', [PendaftaranController::class, 'getPayment'])->name('getPayment')->middleware('auth');
// route cost
Route::get('/cost/{student:id}/{id}', [PendaftaranController::class, 'indexCost'])->middleware('auth'); //{id} ini adalah aktivasi_id
Route::post('/cost-payment-store/{id}', [PendaftaranController::class, 'storeCost'])->middleware('auth');
Route::post('/cost-payment-edit/{id}', [PendaftaranController::class, 'updateDate'])->middleware('auth');


// route kelas
Route::get('/kelas-admin', [KelasAdminController::class, 'index'])->middleware('auth');
Route::post('/kelas-admin', [KelasAdminController::class, 'index']);
// ----> untuk search engine

Route::get('/kelas-admin/show/{kurikulum:id}', [KelasAdminController::class, 'show'])->middleware('auth');
// ----> untuk melihat kelas berdasarkan kurikulum

Route::get('/kelas-admin/show/student/{student:id}', [KelasAdminController::class, 'showStudent'])->middleware('auth');
// ----> untuk melihat profile siswa detail

Route::get('/kelas-admin/update/student/{student:id}', [KelasAdminController::class, 'editStudent'])->middleware('auth');
Route::post('/kelas-admin/update/student/{student:id}', [KelasAdminController::class, 'updateStudent'])->middleware('auth');
// ----> proses menyimpan data yang telah diubah


Route::get('/kelas-admin/delete/student/{student:nama_siswa}', [KelasAdminController::class, 'destroyStudent'])->middleware('auth');


// route data-siswa
Route::get('/data-siswa', [StudentController::class, 'index']);
Route::get('/autocomplete-data-siswa', [StudentController::class, 'getSiswa']);
Route::post('/data-siswa', [StudentController::class, 'index']);
Route::get('/data-siswa/create/student', [StudentController::class, 'create']);
Route::post('/data-siswa/create/student', [StudentController::class, 'store']);
Route::get('/data-siswa/show/student/{student:id}', [StudentController::class, 'show']);
Route::get('/data-siswa/update/student/{student:id}', [StudentController::class, 'edit']);
Route::post('/data-siswa/update-new/student/{student:id}', [StudentController::class, 'update']);
Route::post('/data-siswa/delete/student/{student:id}', [StudentController::class, 'destroy']);
// export pdf
Route::get('/export-pdf/{student:id}', [StudentController::class, 'export'])->middleware('auth');
// ajax autocomplete
Route::get('/autocomplete', [StudentController::class, 'search'])->name('search');
Route::get('/autocomplete-ktp', [StudentController::class, 'ktp'])->name('ktp');
Route::get('/autocomplete-email', [StudentController::class, 'alamatEmail'])->name('email');


// route aktivasi
Route::get('/aktivasi', [AktivasiController::class, 'index']);
Route::get('/create-aktivasi', [AktivasiController::class, 'create']);
Route::post('/create-aktivasi', [AktivasiController::class, 'store']);
Route::get('/update-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'edit']);
Route::post('/update-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'update']);
Route::get('/show-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'show']);
Route::post('/delete-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'destroy']);
// ajax
Route::get('/program-cek', [AktivasiController::class, 'program'])->name('cariProgram');


// routes program
Route::get('/program', [ProgramController::class, 'index'])->Middleware('auth');
Route::get('/show-program/{program:id}', [ProgramController::class, 'show']);
Route::get('/create', [ProgramController::class, 'create'])->Middleware('auth');
Route::post('/create', [ProgramController::class, 'store']);
Route::get('/update-program/{program:id}', [ProgramController::class, 'edit'])->Middleware('auth');
Route::post('/update-program/{program:id}', [ProgramController::class, 'update']);
Route::post('/delete-program/{program:id}', [ProgramController::class, 'destroy'])->Middleware('auth');

// routes materi
Route::get('/materi/{program:id}', [ProgramController::class, 'indexMateri'])->Middleware('auth');
Route::get('/create-materi/{program:id}', [MateriController::class, 'createMateri'])->Middleware('auth');
Route::post('/create-materi', [MateriController::class, 'storeMateri']);
Route::get('/show-materi/{materi:id}', [MateriController::class, 'showMateri'])->Middleware('auth');
Route::get('/update-materi/{materi:id}', [MateriController::class, 'editMateri'])->Middleware('auth');
Route::post('/update-materi/{materi:id}', [MateriController::class, 'updateMateri']);
Route::post('/delete-materi/{materi:id}', [MateriController::class, 'destroyMateri'])->Middleware('auth');


// route sekolah
Route::get('/sekolah', [SekolahController::class, 'index'])->middleware('auth');
Route::get('/sekolah/create', [SekolahController::class, 'create'])->middleware('auth');
Route::post('/sekolah/store', [SekolahController::class, 'store'])->middleware('auth');
Route::get('/sekolah-show/{sekolah:id}', [SekolahController::class, 'show'])->middleware('auth');
Route::get('/sekolah-update/{sekolah:id}', [SekolahController::class, 'edit'])->middleware('auth');
Route::post('/sekolah-update/{sekolah:id}', [SekolahController::class, 'update'])->middleware('auth');
Route::post('/sekolah-delete/{sekolah:id}', [SekolahController::class, 'delete'])->middleware('auth');

// route pic
Route::get('/pic', [PICController::class, 'index'])->middleware('auth');
Route::get('/pic-create', [PICController::class, 'create'])->middleware('auth');
Route::post('/pic-store', [PICController::class, 'store'])->middleware('auth');
Route::get('/pic-show/{pic:id}', [PICController::class, 'show'])->middleware('auth');
Route::get('/pic-update/{pic:id}', [PICController::class, 'edit'])->middleware('auth');
Route::post('/pic-update/{pic:id}', [PICController::class, 'update'])->middleware('auth');
Route::post('/pic-delete/{pic:id}', [PICController::class, 'delete'])->middleware('auth');

// route teacher
Route::get('/teacher', [TeacherController::class, 'index'])->middleware('auth');
Route::get('/teacher-show/{teacher:id}', [TeacherController::class, 'show'])->middleware('auth');
Route::get('/teacher-create', [TeacherController::class, 'create'])->middleware('auth');
Route::post('/teacher-create', [TeacherController::class, 'store'])->middleware('auth');
Route::get('/teacher-update/{teacher:id}', [TeacherController::class, 'edit'])->middleware('auth');
Route::post('/teacher-update/{teacher:id}', [TeacherController::class, 'update'])->middleware('auth');
Route::post('/teacher-delete/{teacher:id}', [TeacherController::class, 'delete'])->middleware('auth');

// route ruang kelas
Route::get('/classroom', [ClassroomController::class, 'index'])->middleware('auth');
Route::get('/classroom-show/{classroom:id}', [ClassroomController::class, 'show'])->middleware('auth');
Route::get('/classroom-create', [ClassroomController::class, 'create'])->middleware('auth');
Route::post('/classroom-create', [ClassroomController::class, 'store'])->middleware('auth');
Route::get('/classroom-update/{classroom:id}', [ClassroomController::class, 'edit'])->middleware('auth');
Route::post('/classroom-update/{classroom:id}', [ClassroomController::class, 'update'])->middleware('auth');
Route::post('/classroom-delete/{classroom:id}', [ClassroomController::class, 'delete'])->middleware('auth');

// route assign teacher
Route::get('/assign-teacher', [AssignTeacherController::class, 'index'])->middleware('auth');
Route::get('/assign-teacher-show/{materi:id}', [AssignTeacherController::class, 'show'])->middleware('auth');
Route::get('/assign-teacher-create', [AssignTeacherController::class, 'create'])->middleware('auth');
Route::post('/assign-teacher-create', [AssignTeacherController::class, 'store'])->middleware('auth');
Route::get('/assign-teacher-update/{materi:id}', [AssignTeacherController::class, 'edit'])->middleware('auth');
Route::post('/assign-teacher-update/{materi:id}', [AssignTeacherController::class, 'update'])->middleware('auth');
Route::post('/assign-teacher-delete/{materi:id}', [AssignTeacherController::class, 'delete'])->middleware('auth');

// jquery
Route::get('/assign-teacher-create-new', [AssignTeacherController::class, 'materi'])->name('getmateri');
Route::get('/get-teacher', [AssignTeacherController::class, 'getTeacher'])->name('getteacher');


