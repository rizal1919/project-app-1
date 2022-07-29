<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;

class KelasAdminController extends Controller
{
    public function index(Request $request){

        $search = $request->search;
        $programs = Program::when($search, function($query, $search){
            return $query->where('nama_program','like',"%$search%");
        })->paginate(6);

        $category = ['college','engineer','car','man','programmer','developer','asian'];
        
        
        return view('Kelas.index',[

            'title' => 'Kelas',
            'active' => 'Kelas',
            'category' => $category,
            'programs' => $programs
        ]);
    }

    public function show(Request $request, Program $program){

        // dd($program->id);
        // dd(Student::with('program')->Active($program->id)->get());

        $dataSiswa = Student::with('program')->Active($program->id)->get();
        return view('Kelas.show', [
            'title' => 'Kelas',
            'active' => 'Kelas',
            'dataSiswa' => $dataSiswa,
            'program' => $program
        ]);
    }
}
