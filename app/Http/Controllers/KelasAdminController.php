<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Builder\Stub;

class KelasAdminController extends Controller
{
    public function index(Request $request){

        $search = $request->search;
        $programs = Program::when($search, function($query, $search){
            return $query->where('nama_program','like',"%$search%");
        })->paginate(6);

        

        $category = ['college','engineer','car','doctor','programmer','developer','asian'];
        
        
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

        // $dataSiswa = Student::with('program')->Active($program->id)->get();
        // $data = Materi::filter(request(['search']))->Active($id)->paginate(5)->withQueryString();


        // $dataSiswa = Student::where('paket_pilihan', $program->id)->get();
        // $dataSiswa = Student::Nama()->get();


        $dataSiswa = Student::where('paket_pilihan', $program->id)->filter(request(['nama','ktp','tahun']))->paginate(5)->withQueryString();
        return view('Kelas.show', [
            'title' => 'Kelas',
            'active' => 'Kelas',
            'dataSiswa' => $dataSiswa,
            'program' => $program
        ]);
    }

    public function showStudent(Student $student){

        // $program = Program::with('student')->get();
        $program = Program::where('id', $student->paket_pilihan)->get();


        // untuk mengubah format tanggal menjadi dd-mm-yyyy
        $str = $student->tanggal_lahir;
        $str2 = explode("-",$str);
        $rightYear = $str2[2] . '-' . $str2[1] . '-' . $str2[0];
        $student->tanggal_lahir = $rightYear;
        
    
        return view('Kelas.Students.student',[

            'title' => 'Student',
            'active' => 'Data Siswa',
            'student' => $student,
            'program' => $program

        ]);
    }

    public function editStudent(Student $student){

        return view('Kelas.Students.update',[
            'title' => 'Update Student',
            'active' => 'Kelas'

        ]);
    }
}
