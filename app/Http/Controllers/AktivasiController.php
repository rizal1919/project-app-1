<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AktivasiStudent;
use App\Models\Category;
use App\Models\Materi;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AktivasiController extends Controller
{
    public function index(Request $request){

        $data = Aktivasi::Filter(Request(['search']))->orderByDesc('id')->paginate(5)->withQueryString();
       
        
        foreach( $data as $item ){

            $item['pembukaan'] = date('d M Y', strtotime($item['pembukaan']));
            $item['penutupan'] = date('d M Y', strtotime($item['penutupan']));
            $item['biaya'] = "Rp" . number_format($item['biaya'], 2, ",", ".");
        }

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

       

        return view('Aktivasi.details', [
            'active' => 'Aktivasi',
            'programs' => $aktivasi->program,
            'aktivasi' => $aktivasi,
            'datas' => $rakTotal,
            'dibagiProgram' => $aktivasi->program->count()
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
