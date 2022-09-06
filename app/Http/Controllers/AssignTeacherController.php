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

        $daftarGuruDitugaskan = DB::table('assign_teachers')->get();
        $daftarGuru = Teacher::all();
        $daftarAktivasi = Aktivasi::all();
        $daftarProgram = Program::all();

        $rakSementara = [];

        function jadikanSatuArray($id, $namaGuru, $namaAktivasi, $namaMateri, $status, $pertemuan, $tanggal, $updatedAt){

            if( $status === 0 ){
                $status = 'Belum Terlaksana';
            }else{
                $status = 'Terlaksana';
            }

            $array = [
                'idPenugasan' =>$id,
                'teacher_name' => $namaGuru,
                'nama_aktivasi' => $namaAktivasi,
                'nama_materi' => $namaMateri,
                'status' => $status,
                'pertemuan' => $pertemuan,
                'tanggal' => $tanggal,
                'updated_at' => $updatedAt

            ];

            return $array;
        }

        foreach( $daftarGuruDitugaskan as $guru ){

            $idTugas = $guru->id;

            $idGuru = $guru->teacher_id;
            $namaGuru = $daftarGuru->find($idGuru)->teacher_name;

            $idAktivasi = $guru->aktivasi_id;
            $namaAktivasi = $daftarAktivasi->find($idAktivasi)->nama_aktivasi;

            $idProgram = $daftarAktivasi->find($idAktivasi)->program_id;
            $namaMateri = $daftarProgram->find($idProgram)->materi->find($guru->materi_id)->nama_materi;

            $status = $guru->status;
            $tanggal = $guru->tanggal;
            $pertemuan = $guru->pertemuan;
            $updatedAt = $guru->updated_at;


            array_push($rakSementara, jadikanSatuArray($idTugas, $namaGuru, $namaAktivasi, $namaMateri, $status, $pertemuan, $tanggal, $updatedAt));

        }

        $teacher_name = $request->teacher_name;
        $rakSementara = collect($rakSementara)->filter(function ($item) use ($teacher_name) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['teacher_name'], $teacher_name);
        });

        $rakSementara = collect($rakSementara)->sortByDesc('updated_at');
        $rakSemuaHasilData = (new Collection($rakSementara))->paginate(5);

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

    public function create(){

       
        // dd($hasilMerge);
        // $text = $hasilMerge[3]['namaProgram'];
        // dd($text);
        // dd(strpos($text, 'Aktivasi'));
        // kalau false berarti kurikulum
        // kalau 0 berarti aktivasi
        
        

        // if( strpos($text, 'Aktivasi') === 0 ){

        //     $text = explode(' ', $text);
        //     $idPaket = (int)end($text);
        //     $idProgramDiDalamPaket = Aktivasi::find($idPaket)->program->id;
        //     $materiDiDalamProgram = Program::find($idProgramDiDalamPaket)->materi;
        //     // dd($materiDiDalamProgram);

        //     $option = "<option>Pilih Materi Aktivasi...</option>";
        //     foreach( $materiDiDalamProgram as $materi ){
        //         $option .= "<option value='$materi->id'>$materi->nama_materi</option>";
        //     }

        //     echo $option;

        // }else if( strpos($text, 'Aktivasi') === false ){
        //     $text = explode(' ', $text);
        //     $idPaket = (int)end($text);
        //     $programs = Kurikulum::find($idPaket)->program;
        //     // dd($programs);
            
        //     $array = [];
        //     foreach( $programs as $program ){

        //         $materiDiDalamProgram = Program::find($program->id)->materi;
        //         foreach( $materiDiDalamProgram as $materi ){

        //             $rak = [
        //                 'id' => $materi->id,
        //                 'nama_materi' => $materi->nama_materi
        //             ];

        //             array_push($array, $rak);
        //         }

        //     }
        //     // dd($array);

        //     $option = "<option>Pilih Materi Kurikulum...</option>";
        //     foreach( $array as $materi ){

        //         $id = $materi['id'];
        //         $nama_materi = $materi['nama_materi'];

        //         $option .= "<option value=" . $id . ">" . $nama_materi . "</option>";
        //     }

            

        //     echo $option;
        // }


        return view('AssignGuru.create', [

            'title' => 'Penugasan Guru - ',
            'active' => 'Penugasan Guru',
            'teachers' => Teacher::all(),
            'aktivasis' => Aktivasi::all(),
            'materis' => Materi::all(),
            'programs' => Program::all(),
            
        ]);
    }

       


    public function store(Request $request){


        if( $request->teacher_id == 0 ){

            return redirect('/assign-teacher-create')->with('teacher', 'Nama Guru');
        }

        if( $request->aktivasi_id == 0 ){

            return redirect('/assign-teacher-create')->with('aktivasi', 'Nama Aktivasi');
        }

        if( $request->materi_id == 0 ){

            return redirect('/assign-teacher-create')->with('materi', 'Nama Materi');
        }

        $validatedData = $request->validate([

            'teacher_id' => 'required',
            'aktivasi_id' => 'required',
            'materi_id' => 'required',
            'status' => 'required|between:0,1',
            'pertemuan' => 'required|min:1',
            'tanggal' => 'required'
        ]);

        AssignTeacher::create($validatedData);

        return redirect('/assign-teacher-create')->with('create', 'Berhasil');


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
