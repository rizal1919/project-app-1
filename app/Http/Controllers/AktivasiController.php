<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AktivasiStudent;
use App\Models\AssignTeacher;
use App\Models\Category;
use App\Models\Materi;
use App\Models\Program;
use Hamcrest\Core\IsNot;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use PDO;

use function PHPUnit\Framework\isNull;

class AktivasiController extends Controller
{
    public function index(Request $request){

        

        $data = Aktivasi::Filter(Request(['search']))->orderByDesc('id')->paginate(5)->withQueryString();
       
        
        foreach( $data as $item ){

            $item['pembukaan'] = date('d M Y', strtotime($item['pembukaan']));
            $item['penutupan'] = date('d M Y', strtotime($item['penutupan']));
            $item['biaya'] = "Rp" . number_format($item['biaya'], 2, ",", ".");
        }

        // dd(auth('teacher')->user()->id);

        if( auth('teacher')->check() ){
            
            $data = [];
            $rakAktivasi = [];
            $teacher = AssignTeacher::where(['teacher_id' => auth('teacher')->user()->id])->get();
            
            if( $teacher->count() > 0 ){

                foreach( $teacher as $aktivasi ){

                    if( in_array($aktivasi->aktivasi_id, $rakAktivasi) ){
                        continue;
                    }
                    array_push($rakAktivasi, $aktivasi->aktivasi_id);
                }
            }

            foreach( $rakAktivasi as $aktivasi ){

                $fetchAktivasi = Aktivasi::find($aktivasi);
                array_push($data, $fetchAktivasi);
            }

            
            $data = collect($data);
            foreach( $data as $item ){

                $item['pembukaan'] = date('d M Y', strtotime($item['pembukaan']));
                $item['penutupan'] = date('d M Y', strtotime($item['penutupan']));
                $item['biaya'] = "Rp" . number_format($item['biaya'], 2, ",", ".");
            }

            $nama_aktivasi = $request->search;
            $data = collect($data)->filter(function ($item) use ($nama_aktivasi) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['nama_aktivasi'], $nama_aktivasi);
            });

            $data = (new \App\Models\Collection($data))->paginate(5)->withQueryString();

        }
        
        // dd($data);
        return view('Aktivasi.index', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'aktivasi' => $data,
           
        ]);
    }

    public function show(Aktivasi $aktivasi){

        

        $aktivasi['biaya'] = "Rp" . number_format($aktivasi['biaya'], 2, ",", ".");
        $aktivasi['pembukaan'] = date('d M Y', strtotime($aktivasi['pembukaan']));
        $aktivasi['penutupan'] = date('d M Y', strtotime($aktivasi['penutupan']));

        return view('Aktivasi.show', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'dataAktivasi' => $aktivasi
        ]);
    }

    public function create(){

       
        return view('Aktivasi.create', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'programs' => Program::all()
        ]);
    }



    public function store(Request $request){

        $belumAdaProgram =  $request->collect()->count() < 4 ;
        if( $belumAdaProgram ){
            return redirect('/aktivasi')->with('createFailed', 'Gagal!');
        }
        
        $validatedData = $request->validate([
            
            'nama_aktivasi' => 'required',
            'biaya' => 'required',
            'pembukaan' => 'required',
            'penutupan' => 'required'
        ]);
        
        $checkToday = date('Y-m-d');
        $today = date('d M Y', strtotime($checkToday));
        $opening = date('d M Y', strtotime($validatedData['pembukaan']));
        $closing = date('d M Y', strtotime($validatedData['penutupan']));
        
        if($today >= $opening && $today <= $closing){
            $validatedData['status'] = 'Dibuka';
        }else{
            $validatedData['status'] = 'Ditutup';
        }
        
        Aktivasi::create($validatedData);
        $aktivasi_id = Aktivasi::where('nama_aktivasi', $validatedData['nama_aktivasi'])->first()->id;

        if(count($request->collect()) > 4){
            
            $i=0;
            foreach( $request->collect() as $data ){
                
                if( $i>4 ){

                    DB::table('aktivasi_program')->insert([
                        'aktivasi_id' => $aktivasi_id,
                        'program_id' => $data
                    ]);
                }
                $i++;
            }

            

        }

        return redirect('/aktivasi')->with('create', $validatedData['nama_aktivasi']);
    }

    public function edit(Aktivasi $aktivasi){

        $cek = [];
        foreach( $aktivasi->program as $count){

            array_push($cek, $count->id);
        }

        return view('Aktivasi.update', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'aktivasi' => $aktivasi,
            'programs' => Program::all(),
            'chosenPrograms' => $cek
        ]);
    }

    public function update(Request $request, Aktivasi $aktivasi){

        $belumAdaProgram =  $request->collect()->count() < 4 ;
        if( $belumAdaProgram ){
            return redirect('/aktivasi')->with('createFailed', 'Gagal!');
        }

        $validatedData = $request->validate([

            'nama_aktivasi' => 'required',
            'biaya' => 'required',
            'pembukaan' => 'required',
            'penutupan' => 'required'
        ]);
        
        $checkToday = date('Y-m-d');
        $today = date('d M Y', strtotime($checkToday));
        $opening = date('d M Y', strtotime($validatedData['pembukaan']));
        $closing = date('d M Y', strtotime($validatedData['penutupan']));
        
        if($today >= $opening && $today <= $closing){
            $validatedData['status'] = 'Dibuka';
        }else{
            $validatedData['status'] = 'Ditutup';
        }
        
        $aktivasi->update([
            'nama_aktivasi' => $validatedData['nama_aktivasi'],
            'biaya' => $validatedData['biaya'],
            'status' => $validatedData['status'],
            'pembukaan' => $validatedData['pembukaan'],
            'penutupan' => $validatedData['penutupan'],
        ]);
 
        if(count($request->collect()) > 4){
            
            DB::table('aktivasi_program')->where('aktivasi_id', $aktivasi->id)->delete();
            
            $i=0;
            foreach( $request->collect() as $data ){
                
                if( $i>4 ){

                    DB::table('aktivasi_program')->insert([
                        'aktivasi_id' => $aktivasi->id,
                        'program_id' => $data
                    ]);
                }
                $i++;
            }
        }

        return redirect('/aktivasi')->with('update', $validatedData['nama_aktivasi']);
    }

    public function destroy(Aktivasi $aktivasi){


        DB::table('aktivasi_program')->where('aktivasi_id', $aktivasi->id)->delete();

        Aktivasi::find($aktivasi->id)->delete();

        return redirect('/aktivasi')->with('destroy', $aktivasi->nama_aktivasi);

    }

    public function indexDetails(Aktivasi $aktivasi){
 
        
        // bagian ini untuk membatasi program mana saja yang perlu ditampilkan sesuai dengan id guru
        if( auth('teacher')->check() ){
            // cek apakah guru login

            $daftarProgram = [];
            // untuk menyimpan id program-program

            $cariProgram = AssignTeacher::where(['aktivasi_id' => $aktivasi->id, 'teacher_id' => auth('teacher')->user()->id])->get();
            // query penugasan yang aktivasi dan guru nya sesuai. tujuannya adalah mengumpulkan materi2 yang diampu oleh guru

            foreach( $cariProgram as $program ){
    
                $data = Materi::find($program->materi_id);
                // cari materi sesuai id
    
                if( $data != null ){
                // jika ada, cek lagi apakah id program sudah masuk dalam array atau belum
    
                    if( in_array($data->program->id, $daftarProgram) ){
    
                        continue;
                    }else{
                        
                        array_push($daftarProgram, $data->program->id);
                    }
    
                   
                }
            }
        }

        $arrayProgram = [];
        $rakS = [];
        $rakP = [];
        $rakTotal = [];
        $programs = [];
        foreach( $aktivasi->program as $program ){

            $arrayProgram = [];
            $rakP = [];

            if( auth('teacher')->check() ){
            // cek apakah guru sedang login dan program id yang dilooping sekarang ada di dalam daftar program yang diambil gurunya
                

                if( in_array($program->id, $daftarProgram) ){
                // cek pula apakah id program saat ini ada dalam daftar program yang diquery sebelumnya di atas
    
                    foreach( $program->materi as $materi ){
                    // cari materi id nya kemudian masukkan ke daftar

                        array_push($arrayProgram, $materi->id);
                    }
                    
                    foreach( $aktivasi->student as $student ){
        
                        $rakS = [];
        
                        $daftarNilai = DB::table('daftar_nilai')->where([
                            'student_id' => $student->id,
                            'aktivasi_id' => $aktivasi->id
                        ])->get();
                        $totalNilai = 0;
                        foreach( $daftarNilai as $nilai ){
        
                            $rakM = [];
        
                            if(in_array($nilai->materi_id, $arrayProgram, TRUE)){
        
                                $dataMateri = Materi::find($nilai->materi_id);
                                // dd($dataMateri);
        
                                if( $dataMateri->bobot_persen ){
        
                                    $totalNilai = $totalNilai + $nilai->nilai*($dataMateri->bobot_persen/100);
        
                                    $rakM = [
                                        'idPenilaian' => $nilai->id,
                                        'nama_siswa' => $student->nama_siswa,
                                        'idSiswa' => $student->id,
                                        'idAktivasi' => $aktivasi->id,
                                        'idProgram' => $program->id,
                                        'nilai' => $nilai->nilai*($dataMateri->bobot_persen/100),
                                        'total_nilai' => $totalNilai,
                                        'nama_materi' => $dataMateri->nama_materi,
                                        'bobot_materi' => $dataMateri->bobot_persen
                                    ];
        
                                    array_push($rakS, $rakM);
                                }
        
                            }
        
                        }
        
                        array_push($rakP, $rakS);
        
                    }

                    array_push($rakTotal, $rakP);
                    array_push($programs, $program->nama_program);
                    
                }

                
            }else{

                foreach( $program->materi as $materi ){
                    array_push($arrayProgram, $materi->id);
                }
                
                foreach( $aktivasi->student as $student ){
    
                    $rakS = [];
    
                    $daftarNilai = DB::table('daftar_nilai')->where([
                        'student_id' => $student->id,
                        'aktivasi_id' => $aktivasi->id
                    ])->get();
                    $totalNilai = 0;
                    foreach( $daftarNilai as $nilai ){
    
                        $rakM = [];
    
                        if(in_array($nilai->materi_id, $arrayProgram, TRUE)){
    
                            $dataMateri = Materi::find($nilai->materi_id);
                            // dd($dataMateri);
    
                            if( $dataMateri->bobot_persen ){
    
                                $totalNilai = $totalNilai + $nilai->nilai*($dataMateri->bobot_persen/100);
    
                                $rakM = [
                                    'idPenilaian' => $nilai->id,
                                    'nama_siswa' => $student->nama_siswa,
                                    'idSiswa' => $student->id,
                                    'idAktivasi' => $aktivasi->id,
                                    'idProgram' => $program->id,
                                    'nilai' => $nilai->nilai*($dataMateri->bobot_persen/100),
                                    'total_nilai' => $totalNilai,
                                    'nama_materi' => $dataMateri->nama_materi,
                                    'bobot_materi' => $dataMateri->bobot_persen
                                ];
    
                                array_push($rakS, $rakM);
                            }
    
                        }
    
                    }
    
                    array_push($rakP, $rakS);
    
                }
    
                array_push($rakTotal, $rakP);

                array_push($programs, $program->nama_program);
            }


        }

        // hasil dari query kondisi di atas adalah array bertingkat
        // array level 1 adalah untuk program
        // array level 2 adalah jumlah siswa
        // array level 3 atau paling dalam adalah materi-materi
        

        return view('Aktivasi.details', [
            'active' => 'Aktivasi',
            'programs' => $programs,
            'aktivasi' => $aktivasi,
            'datas' => $rakTotal
        ]);
    }

    public function editDetails(Request $request){


        $data = DB::table('daftar_nilai')->where([
            'student_id' => $request->studentId,
            'aktivasi_id' => $request->aktivasiId
        ])->get();

        $programs = Program::find($request->programId);
        $rakProgram = [];
        foreach( $programs->materi as $materi ){

            array_push($rakProgram, $materi->id);
        }

        $rakMateri = [];
        foreach( $data as $materi ){

            $dataMateri = \App\Models\Materi::find($materi->materi_id);

            if( in_array($dataMateri->id, $rakProgram) ){

                if( $dataMateri->bobot_persen ){
    
                    $rak = [
                        'id' => $dataMateri->id,
                        'nama_materi' => $dataMateri->nama_materi,
                        'nilai' => $materi->nilai
                    ];
    
                    array_push($rakMateri, $rak);
                }
            }
        }

        
        return view('Aktivasi.editform', [
            'number' => $request->idDaftarNilai,
            'materis' => $rakMateri
        ]);
    }

    public function updateDetails(Request $request){

        $data = $request->collect();
        
        $nilai = DB::table('daftar_nilai')->where(['id' => $request->daftarNilai])->get();
        
        $RAK = [];
        foreach( $data as $dat => $val ){

            $word = explode('_', strval($dat));
            if( $dat != 'daftarNilai' ){
             
                DB::table('daftar_nilai')->where([
                    'student_id' => $nilai[0]->student_id,
                    'aktivasi_id' => $nilai[0]->aktivasi_id,
                    'materi_id' => (int)$word[1]
                ])->update(['nilai' => $val]);
            }
        }

       

        $aktivasi = Aktivasi::find($nilai[0]->aktivasi_id);

        $arrayProgram = [];
        $rakS = [];
        $rakP = [];
        $rakTotal = [];
        foreach( $aktivasi->program as $program ){

            $arrayProgram = [];
            $rakP = [];

            
            foreach( $program->materi as $materi ){
                array_push($arrayProgram, $materi->id);
            }
            // dd($arrayProgram);
            // dd($aktivasi->program[0]->materi);
            
            foreach( $aktivasi->student as $student ){

                $rakS = [];

                $daftarNilai = DB::table('daftar_nilai')->where([
                    'student_id' => $student->id,
                    'aktivasi_id' => $aktivasi->id
                ])->get();
                $totalNilai = 0;
                foreach( $daftarNilai as $nilai ){

                    $rakM = [];

                    if(in_array($nilai->materi_id, $arrayProgram, TRUE)){

                        $dataMateri = Materi::find($nilai->materi_id);
                        // dd($dataMateri);

                        if( $dataMateri->bobot_persen ){

                            $totalNilai = $totalNilai + $nilai->nilai*($dataMateri->bobot_persen/100);

                            $rakM = [
                                'idPenilaian' => $nilai->id,
                                'nama_siswa' => $student->nama_siswa,
                                'idSiswa' => $student->id,
                                'idAktivasi' => $aktivasi->id,
                                'idProgram' => $program->id,
                                'nilai' => $nilai->nilai*($dataMateri->bobot_persen/100),
                                'total_nilai' => $totalNilai,
                                'nama_materi' => $dataMateri->nama_materi,
                                'bobot_materi' => $dataMateri->bobot_persen
                            ];

                            array_push($rakS, $rakM);
                        }

                    }

                }

                array_push($rakP, $rakS);

            }

            array_push($rakTotal, $rakP);

        }

        

        return view('Aktivasi.updateform', [
            'active' => 'Aktivasi',
            'programs' => $aktivasi->program,
            'datas' => $rakTotal,
            'alert' => 'Success!',
            'dibagiProgram' => $aktivasi->program->count()
        ]);
       
    }
}
