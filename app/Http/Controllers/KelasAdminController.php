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


        $dataSiswa = Student::where('program_id', $program->id)->filter(request(['nama','ktp','tahun']))->paginate(5)->withQueryString();
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
            'active' => 'Kelas',
            'year' => date('Y'),
            'date' => date("Y-m-d"),
            'student' => $student,
            'programs' => Program::all()

        ]);
    }

    public function storeStudent(Request $request, Student $student){

        // dd($request);

        $validatedData = $request->validate([

            'nama_siswa' => 'required',
            'program_id' => 'required',
            'ktp' => 'required|min:16|max:16',
            'email' => 'required|email:dns',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'password' => 'required',
            'nomor_pendaftaran' => 'required',
            'tahun_daftar' => 'required'
        ],[
            'nama_siswa.required' => 'Nama harus diisi',
            'program_id.required' => 'Paket pilihan tidak boleh kosong',
            'ktp.required' => 'KTP tidak boleh kosong',
            'ktp.min' => 'KTP terdiri dari minimal 16 angka',
            'ktp.max' => 'KTP terdiri dari maksimal 16 angka',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Pastikan email seperti example@gmail.com',
            'email.unique' => 'Email telah terdaftar',
            'tanggal_lahir' => 'Tanggal lahir tidak boleh kosong',
            'tanggal_lahir' => 'Format tanggal tidak sesuai',
        ]);

        $id = $student->id;

        if($validatedData['program_id'] == 0){

            return redirect('/kelas-admin/update/student/' . $id)->with('updateGagal', 'Update Gagal!!');
        }

        $student->update([
            'nama_siswa' => $validatedData['nama_siswa'],
            'program_id' => $validatedData['program_id'],
            'ktp' => $validatedData['ktp'],
            'email' => $validatedData['email'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'password' => $validatedData['password'],
            'nomor_pendaftaran' => $validatedData['nomor_pendaftaran'],
            'tahun_daftar' => $validatedData['tahun_daftar'],
        ]);

        return redirect('/kelas-admin/update/student/' . $id)->with('updateBerhasil', 'Berhasil Ubah Data!! ');

    }

    public function destroyStudent(Request $request, Student $student)
    {
        // $program->delete($request);
        // return back()->with('destroy','Deleted Successfully!');

        
        $id = $student->program_id;

        Student::find($student->id)->delete();
    
        return redirect('/kelas-admin/show/' . $id)->with('destroy', 'Deleted Successfully!');
        
        
    }
}
