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
use App\Models\Aktivasi;
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

// Route::get('/tes-design', function(){
//     return view('Design.index', [
//         'active' => 'Home'
//     ]);
// });

// routes login
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login-admin', [LoginController::class, 'authenticate']);
Route::post('/logout-admin', [LoginController::class, 'logout']);


// routes dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('administrator');
Route::get('/export-pdf', [DashboardController::class, 'exportPDF'])->middleware('administrator');




// route pendaftaran 
Route::get('/form-registrasi', [PendaftaranController::class, 'index'])->middleware('administrator');
Route::get('/form-registrasi/create', [PendaftaranController::class, 'create'])->middleware('administrator');
Route::post('/form-registrasi/create', [PendaftaranController::class, 'store'])->middleware('administrator');
Route::post('/form-registrasi-softdelete/{student_id}/{activation_id}', [PendaftaranController::class, 'softDeleteStudent'])->middleware('administrator');
Route::get('/form-registrasi/getStudent', [PendaftaranController::class, 'getStudent'])->name('getStudent')->middleware('administrator');
Route::get('/form-registrasi/getPayment', [PendaftaranController::class, 'getPayment'])->name('getPayment')->middleware('administrator');
// route cost
Route::get('/cost/{student:id}/{id}', [PendaftaranController::class, 'indexCost'])->middleware('administrator'); //{id} ini adalah aktivasi_id
Route::post('/cost-payment-store/{id}', [PendaftaranController::class, 'storeCost'])->middleware('administrator');
Route::post('/cost-payment-edit/{id}', [PendaftaranController::class, 'updateDate'])->middleware('administrator');


// route data-siswa
Route::get('/data-siswa', [StudentController::class, 'index'])->middleware('administrator');
Route::get('/autocomplete-data-siswa', [StudentController::class, 'getSiswa'])->middleware('administrator');
Route::post('/data-siswa', [StudentController::class, 'index'])->middleware('administrator');
Route::get('/data-siswa/create/student', [StudentController::class, 'create'])->middleware('administrator');
Route::post('/data-siswa/create/student', [StudentController::class, 'store'])->middleware('administrator');
Route::get('/data-siswa/show/student/{student:id}', [StudentController::class, 'studentDashboard'])->middleware('administrator');
Route::get('/data-siswa/update/student/{student:id}', [StudentController::class, 'edit'])->middleware('administrator');
Route::post('/data-siswa/update-new/student/{student:id}', [StudentController::class, 'update'])->middleware('administrator');
Route::post('/data-siswa/delete/student/{student:id}', [StudentController::class, 'destroy'])->middleware('administrator');
// export pdf
Route::get('/export-pdf/{student:id}', [StudentController::class, 'export'])->middleware('administrator');
// ajax autocomplete
Route::get('/autocomplete', [StudentController::class, 'search'])->name('search')->middleware('administrator');
Route::get('/autocomplete-ktp', [StudentController::class, 'ktp'])->name('ktp')->middleware('administrator');
Route::get('/autocomplete-email', [StudentController::class, 'alamatEmail'])->name('email')->middleware('administrator');


// route aktivasi
Route::get('/aktivasi', [AktivasiController::class, 'index'])->middleware('administrator');
Route::get('/create-aktivasi', [AktivasiController::class, 'create'])->middleware('administrator');
Route::post('/create-aktivasi', [AktivasiController::class, 'store'])->middleware('administrator');
Route::get('/update-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'edit'])->middleware('administrator');
Route::post('/update-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'update'])->middleware('administrator');
Route::get('/show-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'show'])->middleware('administrator');
Route::post('/delete-aktivasi-program/{aktivasi:id}', [AktivasiController::class, 'destroy'])->middleware('administrator');
// daftar nilai
Route::get('/details/{aktivasi:id}', [AktivasiController::class, 'indexDetails'])->middleware('administrator');
// ajax
Route::get('/program-cek', [AktivasiController::class, 'program'])->name('cariProgram')->middleware('administrator');
Route::get('/edit', [AktivasiController::class, 'editDetails'])->name('edit')->middleware('administrator');
Route::get('/update', [AktivasiController::class, 'updateDetails'])->name('update')->middleware('administrator');


// routes program
Route::get('/program', [ProgramController::class, 'index'])->middleware('administrator');
Route::get('/show-program/{program:id}', [ProgramController::class, 'show'])->middleware('administrator');
Route::get('/create', [ProgramController::class, 'create'])->middleware('administrator');
Route::post('/create', [ProgramController::class, 'store'])->middleware('administrator');
Route::get('/update-program/{program:id}', [ProgramController::class, 'edit'])->middleware('administrator');
Route::post('/update-program/{program:id}', [ProgramController::class, 'update'])->middleware('administrator');
Route::post('/delete-program/{program:id}', [ProgramController::class, 'destroy'])->middleware('administrator');

// routes materi
Route::get('/materi/{program:id}', [MateriController::class, 'index'])->middleware('administrator');
Route::get('/create-materi/{program:id}', [MateriController::class, 'createMateri'])->middleware('administrator');
Route::post('/create-materi', [MateriController::class, 'storeMateri'])->middleware('administrator');
Route::get('/show-materi/{materi:id}', [MateriController::class, 'showMateri'])->middleware('administrator');
Route::get('/update-materi/{materi:id}', [MateriController::class, 'editMateri'])->middleware('administrator');
Route::post('/update-materi/{materi:id}', [MateriController::class, 'updateMateri'])->middleware('administrator');
Route::post('/delete-materi/{materi:id}', [MateriController::class, 'destroyMateri'])->middleware('administrator');


// route sekolah
Route::get('/sekolah', [SekolahController::class, 'index'])->middleware('administrator');
Route::get('/sekolah/create', [SekolahController::class, 'create'])->middleware('administrator');
Route::post('/sekolah/store', [SekolahController::class, 'store'])->middleware('administrator');
Route::get('/sekolah-show/{sekolah:id}', [SekolahController::class, 'show'])->middleware('administrator');
Route::get('/sekolah-update/{sekolah:id}', [SekolahController::class, 'edit'])->middleware('administrator');
Route::post('/sekolah-update/{sekolah:id}', [SekolahController::class, 'update'])->middleware('administrator');
Route::post('/sekolah-delete/{sekolah:id}', [SekolahController::class, 'delete'])->middleware('administrator');

// route pic
Route::get('/pic', [PICController::class, 'index'])->middleware('administrator');
Route::get('/pic-create', [PICController::class, 'create'])->middleware('administrator');
Route::post('/pic-store', [PICController::class, 'store'])->middleware('administrator');
Route::get('/pic-show/{pic:id}', [PICController::class, 'show'])->middleware('administrator');
Route::get('/pic-update/{pic:id}', [PICController::class, 'edit'])->middleware('administrator');
Route::post('/pic-update/{pic:id}', [PICController::class, 'update'])->middleware('administrator');
Route::post('/pic-delete/{pic:id}', [PICController::class, 'delete'])->middleware('administrator');

// route teacher
Route::get('/teacher', [TeacherController::class, 'index'])->middleware('administrator');
Route::get('/teacher-show/{teacher:id}', [TeacherController::class, 'show'])->middleware('administrator');
Route::get('/teacher-create', [TeacherController::class, 'create'])->middleware('administrator');
Route::post('/teacher-create', [TeacherController::class, 'store'])->middleware('administrator');
Route::get('/teacher-update/{teacher:id}', [TeacherController::class, 'edit'])->middleware('administrator');
Route::post('/teacher-update/{teacher:id}', [TeacherController::class, 'update'])->middleware('administrator');
Route::post('/teacher-delete/{teacher:id}', [TeacherController::class, 'delete'])->middleware('administrator');

// route ruang kelas
Route::get('/classroom', [ClassroomController::class, 'index'])->middleware('administrator');
Route::get('/classroom-show/{classroom:id}', [ClassroomController::class, 'show'])->middleware('administrator');
Route::get('/classroom-create', [ClassroomController::class, 'create'])->middleware('administrator');
Route::post('/classroom-create', [ClassroomController::class, 'store'])->middleware('administrator');
Route::get('/classroom-update/{classroom:id}', [ClassroomController::class, 'edit'])->middleware('administrator');
Route::post('/classroom-update/{classroom:id}', [ClassroomController::class, 'update'])->middleware('administrator');
Route::post('/classroom-delete/{classroom:id}', [ClassroomController::class, 'delete'])->middleware('administrator');

// route assign teacher
Route::get('/assign-teacher', [AssignTeacherController::class, 'index'])->middleware('administrator');
Route::get('/assign-teacher-show/{materi:id}', [AssignTeacherController::class, 'show'])->middleware('administrator');
Route::post('/assign-teacher-create', [AssignTeacherController::class, 'store'])->middleware('administrator');
Route::get('/assign-teacher-update/{materi:id}/{id}', [AssignTeacherController::class, 'edit'])->middleware('administrator');
Route::post('/assign-teacher-update/{materi:id}/{id}', [AssignTeacherController::class, 'update'])->middleware('administrator');
Route::post('/assign-teacher-delete/{materi:id}/{id}', [AssignTeacherController::class, 'delete'])->middleware('administrator');

// jquery
Route::get('/assign-teacher-create-new', [AssignTeacherController::class, 'materi'])->name('getmateri')->middleware('administrator');
Route::get('/get-teacher', [AssignTeacherController::class, 'getTeacher'])->name('getteacher')->middleware('administrator');


