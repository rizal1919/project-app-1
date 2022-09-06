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

        // idAktivasi
        // namaMateri
        // namaAktivasi
        // statusPelaksanaan
        // statusPenugasan

        $rakSementara = [];
        foreach( $daftarPenugasan as $penugasan ){

            foreach( $daftarAktivasi as $aktivasi ){


                foreach( $aktivasi->program as $program ){

                    
                    foreach( $program->materi as $materi ){

                        
                        if( $materi->teacher->count() > 0 ){

                            
                            $kotakMateri = [

                                'idPenugasan' => $penugasan->id,
                                'namaMateri' => $materi->nama_materi,
                                'namaAktivasi' => $aktivasi->nama_aktivasi,
                                'statusPelaksanaan' => $penugasan->status,
                                'statusPenugasan' => $materi->teacher->first()->teacher_name,
                                'created_at' => $penugasan->created_at,
                                'updated_at' => $penugasan->updated_at
                            ];

                        }else{
                            
                            $kotakMateri = [

                                'idPenugasan' => $penugasan->id,
                                'namaMateri' => $materi->nama_materi,
                                'namaAktivasi' => $aktivasi->nama_aktivasi,
                                'statusPelaksanaan' => $penugasan->status,
                                'statusPenugasan' => 'empty',
                                'created_at' => $penugasan->created_at,
                                'updated_at' => $penugasan->updated_at
                            ];
                        }

                        
                    }
                }
                
                array_push($rakSementara, $kotakMateri);
            }
            
        }

        $rakKedua = [];
        foreach( $rakSementara as $terjemahkanStatus ){

            if( $terjemahkanStatus['statusPelaksanaan'] === 0  ){

                $terjemahkanStatus['statusPelaksanaan'] = 'Belum Terlaksana';
            }else{

                $terjemahkanStatus['statusPelaksanaan'] = 'Terlaksana';
            }

            array_push($rakKedua, $terjemahkanStatus);
        }

        // dd($rakKedua);


        

        
        
        // $teacher_name = $request->teacher_name;
        // $rakSementara = collect($rakSementara)->filter(function ($item) use ($teacher_name) {
        //     // replace stristr with your choice of matching function
        //     return false !== stristr($item['teacher_name'], $teacher_name);
        // });

        $rakSementara = collect($rakKedua)->sortByDesc('updated_at');
        $rakSemuaHasilData = (new Collection($rakSementara))->paginate(20);

        // dd($rakSemuaHasilData);



        return view('AssignGuru.index', [

            'title' => 'Penugasan Guru - ',
            'active' => 'Penugasan Guru',
            'dataGuru' => $rakSemuaHasilData
        ]);
    }

    public function show(AssignTeacher $assignteacher){

        // dd($assignteacher);

        function detailPenugasan($data){

            $daftarGuruDitugaskan = DB::table('assign_teachers')->where('id', $data->id)->get();
            $daftarGuru = Teacher::all();
            $daftarAktivasi = Aktivasi::all();
            $daftarProgram = Program::all();

            $idTugas = $data->id;

            $idGuru = $data->teacher_id;
            $namaGuru = $daftarGuru->find($idGuru)->teacher_name;

            $idAktivasi = $data->aktivasi_id;
            $namaAktivasi = $daftarAktivasi->find($idAktivasi)->nama_aktivasi;

            $idProgram = $daftarAktivasi->find($idAktivasi)->program_id;
            $namaMateri = $daftarProgram->find($idProgram)->materi->find($data->materi_id)->nama_materi;

            $status = $data->status;
            $tanggal = $data->tanggal;
            $pertemuan = $data->pertemuan;
            $updatedAt = $daftarGuruDitugaskan[0]->updated_at;

            if( $status === 0 ){
                $status = 'Belum Terlaksana';
            }else{
                $status = 'Terlaksana';
            }

            return $array = [
                'idPenugasan' =>$idTugas,
                'teacher_name' => $namaGuru,
                'nama_aktivasi' => $namaAktivasi,
                'nama_materi' => $namaMateri,
                'status' => $status,
                'pertemuan' => $pertemuan,
                'tanggal' => $tanggal,
                'updated_at' => $updatedAt
            ];

        }

       

        return view('AssignGuru.show', [
            'title'  => 'Penugasan Guru | ',
            'active' => 'Penugasan Guru',
            'penugasan' => detailPenugasan($assignteacher)
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

        return redirect('/assign-teacher')->with('create', $teacher);


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
