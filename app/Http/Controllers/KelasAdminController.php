<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\KurikulumStudent;
use App\Models\Program;
use App\Models\Student;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // $dataSiswa = Student::where('kurikulum_id', $kurikulum->id)->filter(request(['nama','ktp','tahun']))->paginate(5)->withQueryString();

        // dd($kurikulum);

        $dataSiswa = Student::all();
        $dataSiswaTerdaftar = DB::table('kurikulum_students')->where('kurikulum_id', $kurikulum->id)->get();

        // dd($dataSiswaTerdaftar);

        function jadikanSatuArrayReguler($id, $namaSiswa, $ktp, $email, $status, $tahun_daftar, $updateAt){

            return $arr = [

                'student_id' => $id,
                'nama_siswa' => $namaSiswa,
                'ktp' => $ktp,
                'email' => $email,
                'status' => $status,
                'tahun_daftar' => $tahun_daftar,
                'updated_at' => $updateAt 
            ];

        }

        $dataSiswaReguler = [];

        $i = 0;
        foreach( $dataSiswaTerdaftar as $siswa ){

            $idSiswa = $siswa->student_id;
            $dataTerakhirDiUpdate = $siswa->updated_at;

            $namaSiswa = Student::find($idSiswa)->nama_siswa;
            $ktp = Student::find($idSiswa)->ktp;
            $email = Student::find($idSiswa)->email;
            $status = Student::find($idSiswa)->status;
            $tahun_daftar = Student::find($idSiswa)->tahun_daftar;

            

            $tes = jadikanSatuArrayReguler($idSiswa, $namaSiswa, $ktp, $email, $status, $tahun_daftar, $dataTerakhirDiUpdate);
            array_push($dataSiswaReguler, $tes);

            $i++;
        }

        // ini untuk sorting data terakhir diupdate
        $rakSemuaHasilData = collect($dataSiswaReguler)->sortByDesc('updated_at');


        // ini untuk bagian filtering
        $nama = $request->nama_siswa;
        $ktp = $request->ktp;
        $tahun_daftar = $request->tahun_daftar;
        $rakSemuaHasilData = collect($rakSemuaHasilData)->filter(function ($item) use ($nama) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['nama_siswa'], $nama);
        });
        $rakSemuaHasilData = collect($rakSemuaHasilData)->filter(function ($item) use ($ktp) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['ktp'], $ktp);
        });
        $rakSemuaHasilData = collect($rakSemuaHasilData)->filter(function ($item) use ($tahun_daftar) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['tahun_daftar'], $tahun_daftar);
        });

        $rakSemuaHasilData = (new Collection($rakSemuaHasilData))->paginate(5);

        // dd($rakSemuaHasilData);

        // dd($tes);
        return view('Kelas.show', [
            'title' => 'Kelas',
            'active' => 'Kelas',
            'dataSiswa' => $rakSemuaHasilData,
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
