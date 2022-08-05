<?php

namespace App\Http\Controllers;

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

        $kurikulum = Kurikulum::all();
        $nomorUrut = Student::all()->last();

        

        $year = date("Y")[3] . date("Y")[2];
        // mengambil 2 angka akhir pada tahun

        $normalYear = date('Y');
        $date = date("Y-m-d");
        
        if($nomorUrut === null){
            $hasilAkhirNoUrut = '00001' . $year;
            // dd($hasilAkhirNoUrut);
        }else{
            
            // $str = (string)$nomorUrut;
            // $tes = $str[4];
            $nomorUrut = $nomorUrut->nomor_pendaftaran;

            $array = [];
            for ($i=0; $i < 5; $i++) { 
                
                if( $nomorUrut[$i] == 0 ){
                    continue;
                }
                $array[] = $nomorUrut[$i];
            }

            $str = join("",$array);
            $int = (int)$str;
            $result = $int+1;
            $str = (string)$result;
            $length = count($array);
            
            if( $length == 1 ){
                $hasilAkhirNoUrut = '0000' . $str . $year;
            }elseif( $length == 2 ){
                $hasilAkhirNoUrut = '000' . $str . $year;
            }elseif( $length == 3 ){
                $hasilAkhirNoUrut = '00' . $str . $year;
            }elseif( $length == 4 ){
                $hasilAkhirNoUrut = '0' . $str . $year;
            }elseif( $length == 5 ){
                $hasilAkhirNoUrut = $str . $year;
            }

            
            $hasilAkhirNoUrut;
        
        }


        // ini kondisi ketika belum ada program sama sekali di dalam database
        // jadi disiasati menggunakan fake program yang nantinya bisa dipanggil lewat index. 
        // namun ketika nantinya ada program baru ditambahkan. maka isi program di bawah ini akan di override
        if( count($kurikulum) == 0 ){
           
            $kurikulum = ([

                [
                    'id' => 1,
                    'nama_kurikulum' => 'Tidak Ada Kurikulum'
                ]
            ]);

            
        }
        


        

        return view('Pendaftaran.index', [

            'title' => 'Pendaftaran',
            'active' => 'Pendaftaran',
            'nomor' => $hasilAkhirNoUrut,
            'kurikulums' => $kurikulum,
            'count' => count($kurikulum),
            'year' => $normalYear,
            'date' => $date
        ]);
    }

    public function store1(Request $request){


        $programs = count(Program::all());


        
        $validatedData = $request->validate([

            'nama_siswa' => 'required',
            'kurikulum_id' => 'required',
            'status' => 'required',
            'ktp' => 'required|min:16|max:16|unique:students',
            'email' => 'required|email:dns|unique:students',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'password' => 'required',
            'nomor_pendaftaran' => 'required|unique:students',
            'tahun_daftar' => 'required'
        ],[
            'nama_siswa.required' => 'Nama harus diisi',
            'kurikulum_id.required' => 'Paket pilihan tidak boleh kosong',
            'ktp.required' => 'KTP tidak boleh kosong',
            'ktp.unique' => 'KTP telah digunakan',
            'ktp.min' => 'KTP terdiri dari minimal 16 angka',
            'ktp.max' => 'KTP terdiri dari maksimal 16 angka',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Pastikan email seperti example@gmail.com',
            'email.unique' => 'Email telah terdaftar',
            'tanggal_lahir' => 'Tanggal lahir tidak boleh kosong',
            'tanggal_lahir' => 'Format tanggal tidak sesuai',
        ]);

        if($validatedData['kurikulum_id'] == 0){

            return redirect('/form-registrasi-1')->with('pendaftaranGagal', 'Pendaftaran Gagal!!');
        }

        Student::create($validatedData);

        return redirect('/form-registrasi-2/' . $validatedData['kurikulum_id'])->with('pendaftaranBerhasil', 'Data Berhasil Tersimpan!');

    }

    public function store2(Student $student){

        // $students = Student::all()->find($student->id)->kurikulum;
        // dd($students);

        $dataProgram = Program::where('kurikulum_id', '=', $student->kurikulum_id)->get();

        // dd($dataProgram);

        return view('Pendaftaran.index_2',[
            'title' => 'registrasi kedua',
            'active' => 'Pendaftaran',
            'kurikulum' => Student::all()->find($student->id)->kurikulum,
            'programs' => $dataProgram,
            'student' => $student

        ]);
    }

    public function update(Request $request, Student $student){

        $hasil = $request->collect()->skip(1);
        // kenapa skip(1), karna id 1 itu berisi token form yang ga dibutuhin

        // dd($hasil);

        $idProgram = [];
        for( $i=1; $i<=count($hasil)+1; $i++ ){

            if(!isset($hasil['Program_' . $i])){
                continue;
            }else{
                array_push($idProgram, $hasil['Program_' . $i]);
            }
        }

        $idProgram = implode("-",$idProgram);

        // dd(gettype($idProgram));
        // dd($idProgram);
        
        $student->update([
            'program_id' => $idProgram
        ]);

        return redirect('/dashboard')->with('pendaftaranBerhasil', 'Registrasi Berhasil - ' . $student['nomor_pendaftaran'] . ' ');

    }
}
