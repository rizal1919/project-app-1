<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AssignTeacher;
use App\Models\Materi;
use App\Models\Program;
use App\Models\Collection;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AssignTeacherController extends Controller
{
    public function index(Request $request){

        $daftarGuru = Teacher::all();
        $daftarPenugasan = DB::table('assign_teachers')->get();
        $daftarAktivasi = Aktivasi::all();
        $daftarMateri = Materi::all();

        $rakSementara = [];
        foreach( $daftarAktivasi as $aktivasi ){

    

            foreach( $aktivasi->program as $program ){

                // dd($program);

                foreach ( $program->materi as $materi ){

                    $adaPenugasan = DB::table('assign_teachers')->where('materi_id', $materi->id)->get();

                    
                    if($adaPenugasan->count() > 0){

                        $kotakMateri = [
    
                            'idPenugasan' => $adaPenugasan[0]->id,
                            'idMateri' => $materi->id,
                            'namaMateri' => $materi->nama_materi,
                            'namaAktivasi' => $aktivasi->nama_aktivasi,
                            'statusPelaksanaan' => $adaPenugasan[0]->status,
                            'statusPenugasan' => $materi->teacher->first()->teacher_name,
                            'created_at' => $adaPenugasan[0]->created_at,
                            'updated_at' => $adaPenugasan[0]->updated_at
                        ];
    
                        array_push($rakSementara, $kotakMateri);
    
                            
                        
                    }else{
                        
                        $kotakMateri = [
    
                            'idPenugasan' => '',
                            'idMateri' => $materi->id,
                            'namaMateri' => $materi->nama_materi,
                            'namaAktivasi' => $aktivasi->nama_aktivasi,
                            'statusPelaksanaan' => 0,
                            'statusPenugasan' => 0,
                            'created_at' => '',
                            'updated_at' => ''
                        ];
    
                        array_push($rakSementara, $kotakMateri);
                    }

                }

            }
        }
             
        
        $rakKedua = [];
        foreach( $rakSementara as $terjemahkanStatus ){

            if( $terjemahkanStatus['statusPelaksanaan'] === 0  ){

                $terjemahkanStatus['statusPelaksanaan'] = 'Belum Terlaksana';
            }else{

                $terjemahkanStatus['statusPelaksanaan'] = 'Selesai';
            }

            array_push($rakKedua, $terjemahkanStatus);
        }

        // dd($rakKedua);

        
        
        $teacher_name = $request->teacher_name;
        $rakKedua = collect($rakKedua)->filter(function ($item) use ($teacher_name) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['statusPenugasan'], $teacher_name);
        });

        $nama_aktivasi = $request->nama_aktivasi;
        $rakKedua = collect($rakKedua)->filter(function ($item) use ($nama_aktivasi) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['namaAktivasi'], $nama_aktivasi);
        });
        
        $nama_materi = $request->nama_materi;
        $rakKedua = collect($rakKedua)->filter(function ($item) use ($nama_materi) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['namaMateri'], $nama_materi);
        });

        if( $request->search == 'Belum Terlaksana' ){
            $search = $request->search;
            $rakKedua = collect($rakKedua)->filter(function ($item) use ($search) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['statusPelaksanaan'], $search);
            });
        }
        if( $request->search == 'Selesai' ){
            $terlaksana = $request->search;

            // dd($terlaksana);
            $rakKedua = collect($rakKedua)->filter(function ($item) use ($terlaksana) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['statusPelaksanaan'], $terlaksana);
            });
        }
        if( $request->search == 0 ){
            $penugasan = $request->search;

            // dd($penugasan);
            $rakKedua = collect($rakKedua)->filter(function ($item) use ($penugasan) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['statusPenugasan'], $penugasan);
            });
        }

        // dd($rakKedua);

        if( $request->search == 1 ){
            $penugasan = $request->search;

            // dd($penugasan);
            $rakKedua = collect($rakKedua)->filter(function ($item) use ($penugasan) {
                // replace stristr with your choice of matching function
                return false === stristr($item['statusPenugasan'], 0);
            });
        }
        // dd($rakKedua);

        $rakSementara = collect($rakKedua)->sortBy('statusPenugasan', 0);
        $rakSemuaHasilData = (new Collection($rakSementara))->paginate(5);

        // dd($rakSemuaHasilData);



        return view('AssignGuru.index', [

            'title' => 'Penugasan Guru - ',
            'active' => 'Penugasan Guru',
            'dataGuru' => $rakSemuaHasilData
        ]);
    }

    public function show(Materi $materi){

        // dd($materi);

        $data = DB::table('assign_teachers')->where('materi_id', $materi->id)->get();
        
        
        if(count($data) > 0){
            
            $dataGuru = Teacher::find($data[0]->teacher_id);
            $dataAktivasi = Aktivasi::find($data[0]->aktivasi_id);
            $dataMateri = Materi::find($data[0]->materi_id);

            $rakData = [

                'idPenugasan' => $data[0]->id,
                'namaMateri' => $dataMateri->nama_materi,
                'namaAktivasi' => $dataAktivasi->nama_aktivasi,
                'namaGuru' => $dataGuru->teacher_name,
                'tanggal' => $data[0]->tanggal,
                'status' => $data[0]->status,
                'durasiPertemuan' => $dataMateri->menit,
                'namaProgram' => $dataMateri->program->nama_program
            ];
            
        }else{

            $dataAktivasi = $materi->program->aktivasi;
        
            $rakData = [

                'idPenugasan' => '',
                'namaMateri' => $materi->nama_materi,
                'namaAktivasi' => $dataAktivasi[0]->nama_aktivasi,
                'namaGuru' => 'empty',
                'tanggal' => '',
                'status' => '',
                'durasiPertemuan' => $materi->menit,
                'namaProgram' => $materi->program->nama_program
            ];
        }

        if( $rakData['status'] === 0 ){
            $rakData['status'] = 'Belum Terlaksana';
        }elseif( $rakData['status'] === 1 ){
            $rakData['status'] = 'Selesai';
        }



        // dd($rakData);

       

        return view('AssignGuru.show', [
            'title'  => 'Penugasan Guru | ',
            'active' => 'Penugasan Guru',
            'penugasan' => $rakData
        ]);



    }

    public function create(Request $request){

    
        

        return view('AssignGuru.create', [

            'title' => 'Penugasan Guru - ',
            'active' => 'Penugasan Guru',
            'teachers' => Teacher::all(),
            'aktivasis' => Aktivasi::all(),
            'materis' => Materi::all(),
            'programs' => Program::all(),
            
        ]);
    }

    public function materi(Request $request){

        if($request->id_paket){

            $data = Aktivasi::find($request->id_paket);
    
            
            // idmateri
            // namamateri
            
            $array = [];
            foreach( $data->program as $program ){
    
                
                if(count($program->materi) === 0){
                    continue;
                }else{
    
                    foreach( $program->materi as $materi ){
        
                        $kotakMateri = [
        
                            'idMateri' => $materi->id,
                            'namaMateri' => $materi->nama_materi
                        ];
    
                        array_push($array, $kotakMateri);
                    }
                };
    
            }
    
            $option = "<option value='0' selected disabled>Pilihan Materi - Aktivasi $data->nama_aktivasi</option>";
            foreach( $array as $item){

                $id = $item['idMateri'];
                $nama_materi = $item['namaMateri'];

                $option .= "<option value='$id'>$nama_materi</option>";
            }

            echo $option;
           
        }
    }

    public function getTeacher(Request $request){

        if($request->aktivasi_id){

            $data = Aktivasi::find($request->aktivasi_id);
    
            
            // idmateri
            // namamateri
            
            $array = [];
            foreach( $data->program as $program ){
    
                
                if(count($program->materi) === 0){
                    continue;
                }else{
    
                    foreach( $program->materi as $materi ){
                        
                        if( $materi->teacher->count() === 0 ){

                            $kotakMateri = [
            
                                'idMateri' => $materi->id,
                                'namaMateri' => $materi->nama_materi,
                                'namaGuru' => "-"
                            ];
                        }else{
                            $kotakMateri = [
            
                                'idMateri' => $materi->id,
                                'namaMateri' => $materi->nama_materi,
                                'namaGuru' => $materi->teacher->first()->teacher_name
                            ];

                        }
    
                        array_push($array, $kotakMateri);
                    }
                };
    
            }
            
            $option = "";
            $i=1;
            foreach( $array as $item){
                $option .= "<tr>";

                $id = $item['idMateri'];
                $nama_materi = $item['namaMateri'];
                $nama_guru = $item['namaGuru'];

                $option .= "<td>$i</td>";
                $option .= "<td>$nama_materi</td>";
                $option .= "<td>$nama_guru</td>";
                $option .= "<td><p class='badge text-bg-primary'>Sukses</p></td>";
                $option .= "<td>12 June 1999</td>";

                $option .= "</tr>";
                $i++;
            }

            echo $option;
           
        }

    }

       


    public function store(Request $request){

        
        
        $validatedData = $request->validate([
            
            'teacher_id' => 'required',
            'aktivasi_id' => 'required',
            'materi_id' => 'required',
            'status' => 'required|between:0,1',
            'tanggal' => 'required'
        ]);
            
        DB::table('materi_teacher')->insert([
            'materi_id' => $validatedData['materi_id'],
            'teacher_id' => $validatedData['teacher_id']
        ]);


        AssignTeacher::create($validatedData);
        $teacher = Teacher::find($validatedData['teacher_id']);

        return redirect('/assign-teacher')->with('create', $teacher->teacher_name);


    }

    public function edit(AssignTeacher $assignteacher){

        // dd($assignteacher);

        return view('AssignGuru.update', [

            'title' => 'Penugasan Guru',
            'active' => 'Penugasan Guru',
            'teachers' => Teacher::all(),
            'aktivasis' => Aktivasi::all(),
            'materis' => Materi::all(),
            'programs' => Program::all(),
            'dataguru' => $assignteacher
        ]);
    }

    public function update(Request $request, AssignTeacher $assignteacher){

        // dd($request->collect());

        if( $request->teacher_id == 0 ){

            return redirect('/assign-teacher-update/' . $assignteacher->id)->with('teacher', 'Nama Guru');
        }

        if( $request->aktivasi_id == 0 ){

            return redirect('/assign-teacher-update/' . $assignteacher->id)->with('aktivasi', 'Nama Aktivasi');
        }

        if( $request->materi_id == 0 ){

            return redirect('/assign-teacher-update/' . $assignteacher->id)->with('materi', 'Nama Materi');
        }

        $validatedData = $request->validate([

            'teacher_id' => 'required',
            'aktivasi_id' => 'required',
            'materi_id' => 'required',
            'status' => 'required|between:0,1',
            'pertemuan' => 'required|min:1',
            'tanggal' => 'required'
        ]);

        $assignteacher->update([
            'teacher_id' => $validatedData['teacher_id'],
            'aktivasi_id' =>  $validatedData['aktivasi_id'],
            'materi_id' =>  $validatedData['materi_id'],
            'status' =>  $validatedData['status'],
            'pertemuan' =>  $validatedData['pertemuan'],
            'tanggal' =>  $validatedData['tanggal']
        ]);

        return redirect('/assign-teacher-update/' . $assignteacher->id)->with('update', 'Berhasil');


    }

    public function delete(AssignTeacher $assignteacher){

        $assignteacher->delete();

        return redirect('/assign-teacher')->with('delete', 'Delete Successfully!');
    }

    
}
