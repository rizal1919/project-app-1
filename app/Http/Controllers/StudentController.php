<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){


        $dataSiswa = Student::filter(request(['nama','ktp','tahun']))->orderBy('id', 'desc')->paginate(5)->withQueryString();

        return view('DataSiswa.index',[

            'title' => 'Data Siswa',
            'active' => 'Data Siswa',
            'dataSiswa' => $dataSiswa
        ]);
    }
}
