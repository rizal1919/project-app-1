<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AktivasiStudent;
use App\Models\Kurikulum;
use App\Models\Kurikulum_Student;
use App\Models\KurikulumStudent;
use App\Models\Program;
use App\Models\Student;
use App\Models\UserAdmin;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class PendaftaranController extends Controller
{
    public function index(Request $request){

        
        // $array = [

        //     [
        //         'student_id' => 1,
        //         'nama_siswa' => 'Rizal Fathurrahman',
        //         'nama_kurikulum' => 'Bisnis terpadu'
        //     ],

        //     [
        //         'student_id' => 1,
        //         'nama_siswa' => 'Rizal Fathurrahman',
        //         'nama_kurikulum' => 'Bisnis terpadu'
        //     ]

        // ];

        function jadikanSatuArrayReguler($idstudent, $nama_siswa, $nama_kurikulum, $idregularprogram, $updatedAt){

            $array = [ 

                'id' => $idregularprogram,
                'student_id' => $idstudent,
                'nama_siswa' => $nama_siswa,
                'nama_program' => 'Reguler - ' . $nama_kurikulum,
                'updated_at' => $updatedAt
                
            ];

            return $array;
        }

        function jadikanSatuArrayAktivasi($idstudent, $nama_siswa, $nama_aktivasi, $idregularprogram, $updatedAt){

            $array = [ 

                'id' => $idregularprogram,
                'student_id' => $idstudent,
                'nama_siswa' => $nama_siswa,
                'nama_program' => 'Aktivasi - ' . $nama_aktivasi,
                'updated_at' => $updatedAt
                
            ];

            return $array;
        }
        
       
        $dataKurikulum = Kurikulum::all();
        $dataAktivasi = Aktivasi::all();
        $dataStudent = Student::all();

        

       $dataRegulerStudent = DB::table('kurikulum_students')->get();
       $dataAktivasiStudent = DB::table('aktivasi_students')->get();
    

       

       function ambilNamaTerkait($dataProgramDiDaftarkan, $dataPilihanProgram, $dataStudent){

        $rakDataStudentKurikulum = [];
        
        foreach( $dataProgramDiDaftarkan as $ReqStudent ){
 
             $idKurikulumDidapat = $ReqStudent->kurikulum_id;
             $namaKurikulumDidapat = $dataPilihanProgram->find($idKurikulumDidapat)->nama_kurikulum;
 
             $idStudentDidapat = $ReqStudent->student_id;
             $namaStudentDidapat = $dataStudent->find($idStudentDidapat)->nama_siswa;
 
             $updateAtStudentDidapat = $ReqStudent->updated_at;
 
             $hasilArray = jadikanSatuArrayReguler($idStudentDidapat, $namaStudentDidapat, $namaKurikulumDidapat, $ReqStudent->id, $updateAtStudentDidapat);
             array_push($rakDataStudentKurikulum, $hasilArray);
             
 
             
        }

        return $rakDataStudentKurikulum;

       }

       function ambilNamaAktivasiTerkait($dataProgramDiDaftarkan, $dataPilihanProgram, $dataStudent){

        $rakDataStudentAktivasi = [];
        
        foreach( $dataProgramDiDaftarkan as $ReqStudent ){
 
             $idAktivasiDidapat = $ReqStudent->aktivasi_id;
             $namaAktivasiDidapat = $dataPilihanProgram->find($idAktivasiDidapat)->nama_aktivasi;
 
             $idStudentDidapat = $ReqStudent->student_id;
             $namaStudentDidapat = $dataStudent->find($idStudentDidapat)->nama_siswa;
 
             $updateAtStudentDidapat = $ReqStudent->updated_at;
 
             $hasilArray = jadikanSatuArrayAktivasi($idStudentDidapat, $namaStudentDidapat, $namaAktivasiDidapat, $ReqStudent->id, $updateAtStudentDidapat);
             array_push($rakDataStudentAktivasi, $hasilArray);
             
 
             
        }

        return $rakDataStudentAktivasi;

       }

       
       $rakDataStudentKurikulum = ambilNamaTerkait($dataRegulerStudent, $dataKurikulum, $dataStudent);
       $rakDataStudentAktivasi = ambilNamaAktivasiTerkait($dataAktivasiStudent, $dataAktivasi, $dataStudent);
       $rakMergeData = array_merge($rakDataStudentKurikulum, $rakDataStudentAktivasi);
       
       $rakSemuaHasilData = collect($rakMergeData)->sortByDesc('updated_at');
       
       $items = $request->nama_siswa;
       $kelas = $request->nama_program;
       $rakSemuaHasilData = collect($rakSemuaHasilData)->filter(function ($item) use ($items) {
        // replace stristr with your choice of matching function
            return false !== stristr($item['nama_siswa'], $items);
        });
       $rakSemuaHasilData = collect($rakSemuaHasilData)->filter(function ($item) use ($kelas) {
        // replace stristr with your choice of matching function
            return false !== stristr($item['nama_program'], $kelas);
        });

        
        
        $rakSemuaHasilData = (new Collection($rakSemuaHasilData))->paginate(5);
        // dapet code di atas dari sini -> https://gist.github.com/simonhamp/549e8821946e2c40a617c85d2cf5af5e
        // kemudian bikin file Collection.php di models
        // ganti namespace nya jadi App\Models, kemudian panggil library nya use App\Models\Collection;
        // kemudian cara pakei nya seperti eloquent


        return view('Pendaftaran.index', [

            'title' => 'Pendaftaran',
            'active' => 'Pendaftaran',
            'dataSiswaReguler' => $rakSemuaHasilData
    
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

    public function indexReguler(){

        

        $date = date("Y-m-d");

        return view('Pendaftaran.create_reguler',[

            'active' => 'Pendaftaran',
            'title' => 'Tambah Reguler | ',
            'kurikulums' => Kurikulum::all(),
            'date' => $date
        ]);
    }

    public function storeReguler(Request $request){

        $data = $request->collect();

        // dd($data['ktp']);

        $dataStudent = Student::where('ktp', '=', $data['ktp'])->get();

        // dd($dataStudent[0]->id);

        $dataPendaftar = [

            'student_id' => $dataStudent[0]->id,
            'kurikulum_id' => $data['kurikulum_id'],
        ];



        KurikulumStudent::create($dataPendaftar);

        return redirect('/form-registrasi')->with('pendaftaranBerhasil', $data['nama_siswa']);
    }

    

    public function destroyStudentReguler($id){

        
        // dd($id);

        KurikulumStudent::find($id)->delete();

        return redirect('/form-registrasi')->with('destroy', 'Informasi Terhapus');
    }
}
