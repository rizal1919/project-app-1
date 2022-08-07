<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Builder\Stub;

class KelasAdminController extends Controller
{
    public function index(Request $request){

        $search = $request->search;
        $kurikulums = Kurikulum::when($search, function($query, $search){
            return $query->where('nama_kurikulum','like',"%$search%");
        })->paginate(6);

        

        $category = ['college','engineer','car','minimalist','programmer','developer','student'];
        
        
        return view('Kelas.index',[

            'title' => 'Kelas',
            'active' => 'Kelas',
            'category' => $category,
            'kurikulums' => $kurikulums
        ]);
    }

    public function show(Request $request, Kurikulum $kurikulum){


        $dataSiswa = Student::where('kurikulum_id', $kurikulum->id)->filter(request(['nama','ktp','tahun']))->paginate(5)->withQueryString();
        return view('Kelas.show', [
            'title' => 'Kelas',
            'active' => 'Kelas',
            'dataSiswa' => $dataSiswa,
            'kurikulum' => $kurikulum
        ]);
    }

    public function showStudent(Student $student){

        // $program = Program::with('student')->get();
        $kurikulum = Kurikulum::where('id', $student->kurikulum_id)->get();


        // untuk mengubah format tanggal menjadi dd-mm-yyyy
        $str = $student->tanggal_lahir;
        $str2 = explode("-",$str);
        $rightYear = $str2[2] . '-' . $str2[1] . '-' . $str2[0];
        $student->tanggal_lahir = $rightYear;
        
    
        return view('Kelas.Students.student',[

            'title' => 'Student',
            'active' => 'Data Siswa',
            'student' => $student,
            'kurikulum' => $kurikulum

        ]);
    }

    public function editStudent(Student $student){

        $programs = Program::where('kurikulum_id','=', $student->kurikulum_id)->get();
        
        $id = $student->program_id;
        $id = explode('-', $id);
        
        return view('Kelas.Students.update',[
            'title' => 'Update Student | ',
            'active' => 'Kelas',
            'year' => date('Y'),
            'date' => date("Y-m-d"),
            'student' => $student,
            'programs' => $programs,
            'idProgram' => $id

        ]);
    }

    public function updateStudent(Request $request, Student $student){

        // dd($request->collect());

        $validatedData = $request->validate([

            'nama_siswa' => 'required',
            'ktp' => 'required|min:16|max:16|unique:students,ktp,'.$student->id,
            'email' => 'required|email:dns|unique:students,email,'.$student->id,
            'status' => 'required',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'password' => 'required',
            'nomor_pendaftaran' => 'required',
            'tahun_daftar' => 'required'
        ],[
            'nama_siswa.required' => 'Nama harus diisi',
            'tanggal_lahir' => 'Tanggal lahir tidak boleh kosong',
            'tanggal_lahir' => 'Format tanggal tidak sesuai',
        ]);


        

        // if($request->ktp != $student->ktp){


        //     $validatedData['ktp'] = $request->validate(['ktp' => 'required|min:16|max:16|unique:students']);
        //     $student->update(['ktp' => $validatedData['ktp'] ]);
        // }else{
        //     $validatedData['ktp'] = $request->validate(['ktp' => 'required|min:16|max:16']);
        //     $student->update(['ktp' => $validatedData['ktp'] ]);
        // }
        

        // if($request->email != $student->ktp){
        //     $validatedData['email'] = $request->validate(['email' => 'required|email:dns|unique:students']);
        //     $student->update(['email' => $validatedData['email'] ]);
        // }


        



        // $hasil = $request->collect()->skip(9)->sortDesc();
        // // kenapa skip(1), karna id 1 itu berisi token form yang ga dibutuhin

        // $hasil = current( (Array)$hasil );
        // // ini untuk mengconvert obj menjadi arr dari hasil collection sebelumnya
        
        // $keyPalingBesarUntukCount = array_key_first($hasil);
        // // ini untuk mengambil key array paling besar untuk dijadikan angka kondisi looping di dalam for
        
        // $idProgram = [];
        // for( $i=1; $i<=$keyPalingBesarUntukCount; $i++ ){

        //     if(!isset($hasil[$i])){
        //         continue;
        //     }else{
        //         array_push($idProgram, $hasil[$i]);
        //     }
        // }
        // // looping untuk mengambil value dari array
        
        // $idProgram = implode("-",$idProgram);
        // // integer dari hasil looping di implode dijadikan string dengan pembeda -
        // // dd($idProgram);








        $id = $student->id;

        // if($validatedData['program_id'] == 0){

        //     return redirect('/kelas-admin/update/student/' . $id)->with('updateGagal', 'Update Gagal!!');
        // }

        $student->update([
            'nama_siswa' => $validatedData['nama_siswa'],
            'ktp' => $validatedData['ktp'],
            'email' => $validatedData['email'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'password' => $validatedData['password'],
            'nomor_pendaftaran' => $validatedData['nomor_pendaftaran'],
            'tahun_daftar' => $validatedData['tahun_daftar'],
        ]);

        // dd("berhasil");

        return redirect('/kelas-admin/update/student/' . $id)->with('updateBerhasil', 'Berhasil Ubah Data!! ');

    }

    public function destroyStudent(Request $request, Student $student)
    {
        // $program->delete($request);
        // return back()->with('destroy','Deleted Successfully!');

        
        $id = $student->kurikulum_id;

        Student::find($student->id)->delete();
    
        return redirect('/kelas-admin/show/' . $id)->with('destroy', 'Deleted Successfully!');
        
        
    }
}
