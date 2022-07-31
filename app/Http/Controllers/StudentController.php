<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){


        $dataSiswa = Student::filter(request(['nama','ktp','nama_program','tahun']))->orderBy('id', 'desc')->paginate(5)->withQueryString();
        // $program = Program::filter(request(['nama_program']))->paginate(5)->withQueryString();

        $program = Student::all();

        
        return view('DataSiswa.index',[

            'title' => 'Data Siswa',
            'active' => 'Data Siswa',
            'dataSiswa' => $dataSiswa,
            'program' => $program
        ]);
    }
}
