<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\Kurikulum;
use App\Models\Program;
use App\Models\Student;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class PendaftaranController extends Controller
{
    public function index(){

        

        $array = [

            [
                'student_id' => 1,
                'nama_siswa' => 'Rizal Fathurrahman',
                'nama_kurikulum' => 'Bisnis terpadu'
            ],

            [
                'student_id' => 1,
                'nama_siswa' => 'Rizal Fathurrahman',
                'nama_kurikulum' => 'Bisnis terpadu'
            ]

        ];

        function jadikanSatuArrayReguler($idstudent, $nama_siswa, $nama_kurikulum){

            $array = [ 

                'student_id' => $idstudent,
                'nama_siswa' => $nama_siswa,
                'nama_kurikulum' => $nama_kurikulum
                
            ];

            return $array;
        }
        
       
        $dataKurikulum = Kurikulum::all();
        $dataStudent = Student::all();

        

       $dataRegulerStudent = DB::table('kurikulum_student')->get();
    //    dd($dataRegulerStudent[0]);

       $rakDataStudentKurikulum = [];
       $i = 0;
       foreach( $dataRegulerStudent as $RegStudent ){

            $idKurikulumDidapat = $dataRegulerStudent[$i]->kurikulum_id;
            $namaKurikulumDidapat = $dataKurikulum->find($idKurikulumDidapat)->nama_kurikulum;

            $idStudentDidapat = $dataRegulerStudent[$i]->student_id;
            $namaStudentDidapat = $dataStudent->find($idStudentDidapat)->nama_siswa;

            
            $hasilArray = jadikanSatuArrayReguler($idStudentDidapat, $namaStudentDidapat, $namaKurikulumDidapat);
            array_push($rakDataStudentKurikulum, $hasilArray);
            

            $i++;
       }

       

    
        
        

        // ini kondisi ketika belum ada program sama sekali di dalam database
        // jadi disiasati menggunakan fake program yang nantinya bisa dipanggil lewat index. 
        // namun ketika nantinya ada program baru ditambahkan. maka isi program di bawah ini akan di override
        // if( count($kurikulum) == 0 ){
           
        //     $kurikulum = ([

        //         [
        //             'id' => 1,
        //             'nama_kurikulum' => 'Tidak Ada Kurikulum'
        //         ]
        //     ]);

            
        // }
        


        

        return view('Pendaftaran.index', [

            'title' => 'Pendaftaran',
            'active' => 'Pendaftaran',
            'dataSiswaReguler' => $rakDataStudentKurikulum
            // 'kurikulums' => $kurikulum,
            // 'count' => count($kurikulum),
            // 'year' => $normalYear,
            // 'date' => $date,
            // 'aktivasi' => Aktivasi::all()
        ]);
    }

    public function store1(Request $request){

        dd($request);
        $validatedData = $request->validate([
            
            'nama_siswa' => 'required',
            'ktp' => 'required|min:16|max:16|unique:students',
            'email' => 'required|email:dns|unique:students',
            'tanggal_lahir' => 'required',
            
            
        ],[
            'nama_siswa.required' => 'Nama harus diisi',
            'ktp.required' => 'KTP tidak boleh kosong',
            'ktp.unique' => 'KTP telah digunakan',
            'ktp.min' => 'KTP terdiri dari minimal 16 angka',
            'ktp.max' => 'KTP terdiri dari maksimal 16 angka',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email telah terdaftar',
            'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
        ]);
        
        $validatedData = $request->collect();

        
        $validatedData = current( (Array) $validatedData );
        // kenapa dipanggil dengan collection? karna data yang tidak diinputkan user itu selalu gagal divalidasi.
        // disini makanya diinputkan collection, kemudian dari obj dijadikan array. kemudian di create
        
        if($validatedData['kurikulum_id'] == 0){
            
            return redirect('/form-registrasi-1')->with('pendaftaranGagal', 'Pendaftaran Gagal!!');
        }
        
        // dd($validatedData);
        Student::create($validatedData);

        return redirect('/form-registrasi-1')->with('pendaftaranBerhasil', 'Registrasi Berhasil - ' . $validatedData['nomor_pendaftaran'] . ' ');

    }

    // public function store2(Student $student){

    //     // $students = Student::all()->find($student->id)->kurikulum;
    //     // dd($students);

    //     $dataProgram = Program::where('kurikulum_id', '=', $student->kurikulum_id)->get();

    //     // dd($dataProgram);

    //     return view('Pendaftaran.index_2',[
    //         'title' => 'registrasi kedua',
    //         'active' => 'Pendaftaran',
    //         'kurikulum' => Student::all()->find($student->id)->kurikulum,
    //         'programs' => $dataProgram,
    //         'student' => $student

    //     ]);
    // }

    // public function update(Request $request, Student $student){

    //     // dd($student);

    //     $hasil = $request->collect()->skip(1)->sortDesc();
    //     // kenapa skip(1), karna id 1 itu berisi token form yang ga dibutuhin

    //     // dd($hasil);
        
    //     $hasil = current( (Array)$hasil );
    //     // ini untuk mengconvert obj menjadi arr dari hasil collection sebelumnya
        
    //     $keyPalingBesarUntukCount = array_key_first($hasil);
    //     // ini untuk mengambil key array paling besar untuk dijadikan angka kondisi looping di dalam for
        
    //     $idProgram = [];
    //     for( $i=1; $i<=$keyPalingBesarUntukCount; $i++ ){

    //         if(!isset($hasil[$i])){
    //             continue;
    //         }else{
    //             array_push($idProgram, $hasil[$i]);
    //         }
    //     }
    //     // looping untuk mengambil value dari array
        
    //     $idProgram = implode("-",$idProgram);
    //     // integer dari hasil looping di implode dijadikan string dengan pembeda -
    //     // dd($idProgram);
        
    //     $student->update([
    //         'program_id' => $idProgram
    //     ]);
    //     // disimpan ke data siswa

    //     return redirect('/dashboard')->with('pendaftaranBerhasil', 'Registrasi Berhasil - ' . $student['nomor_pendaftaran'] . ' ');

    // }
}
