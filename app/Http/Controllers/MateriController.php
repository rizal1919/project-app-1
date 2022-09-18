<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Materi;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class MateriController extends Controller
{   
    public function index(Request $request, Program $program){

        $data = Materi::with('program')->where('program_id', $program->id)->Filter(request(['search']))->orderBy('updated_at', 'DESC')->get();
       
        return view('Materi.index', [
            'title' => 'Materi',
            'active' => 'Program',
            'dataProgram' => $program,
            'dataMateri' => $data,
            'total' => $data->sum('bobot_persen')
        ]);
    }
    
    public function createMateri(Program $program){

        $data = Materi::where('program_id', $program->id)->Filter(request(['search']))->get();
        $bobot = 100 - $data->sum('bobot_persen');
        
        return view('Materi.create', [
            'title' => 'Create',
            'active' => 'Data Kurikulum',
            'dataProgram' => $program,
            'total' => $data->sum('bobot_persen'),
            'bobot' => $bobot
        ]);
    }

    public function storeMateri(Request $request, Materi $materi){

        $validatedData = $request->validate([
            'nama_materi'=>'required|unique:materis',
            'program_id'=> 'required|numeric',
            'menit' => 'required|numeric|between:30,240',
            'bobot_persen' => 'nullable'
        ],[
            'nama_materi.required' => 'Silahkan isi terlebih dahulu nama materi',
            'nama_materi.unique' => 'Nama materi telah digunakan, silahkan gunakan nama yang berbeda',
            'menit.required' => 'Durasi menit wajib diisi',
            'menit.numeric' => 'Wajib diisi dengan angka',
            'menit.between' => 'Durasi berkisar antara 30-240 menit / 1-4 Jam',
        ]);

        
        Materi::create($validatedData);

        $id = $validatedData['program_id'];

        return redirect('/materi/' . $id)->with('success',$validatedData['nama_materi']);


        
    }
    
    public function showMateri(Materi $materi){

       
        return view('Materi.show', [
            'title' => 'Materi',
            'active' => 'Data Kurikulum',
            'dataMateri' => $materi,
            'program' => Program::find($materi->program->id)
        ]);
    }

    public function editMateri(Materi $materi){

        

        $data = Materi::where('program_id', $materi->program->id)->get();

        if( $data->sum('bobot_persen') != 0 ){
        // cek sisa bobot nya masih ada ga? kalau ada tambahkan dengan bobot yang sekarang agar nanti dapat diubah sesuai dengan porsi bobot yang tersedia

            $bobot = (100 - $data->sum('bobot_persen')) + $materi->bobot_persen;
        }else{
        // kalau tidak ada sisa, yaudah paksa maksimal pengisian bobot itu sama dengan yang sekarang atau kurang dari itu

            $bobot = $materi->bobot_persen;
        }
        

       
        return view('Materi.update', [
            'title' => 'Materi',
            'active' => 'Program',
            'dataMateri' => $materi,
            'total' => $data->sum('bobot_persen'),
            'bobot' => $bobot
        ]);
    }

    public function updateMateri(Request $request, Materi $materi){

        // dd($request->collect());

        $validatedData = $request->validate([
            'nama_materi'=> ['required', \Illuminate\Validation\Rule::unique('materis')->ignore($materi->id)],
            'program_id'=> 'required|numeric',
            'menit' => 'required|numeric|between:30,240',
            'bobot_persen' => 'nullable'
        ],[
            'nama_materi.required' => 'Silahkan isi terlebih dahulu nama materi',
            'nama_materi.unique' => 'Nama materi telah digunakan, silahkan pilih nama lain',
            'menit.required' => 'Durasi menit wajib diisi',
            'menit.numeric' => 'Wajib diisi dengan angka',
            'menit.between' => 'Durasi berkisar antara 30-240 menit / 1-4 Jam'
        ]);

        $id = $validatedData['program_id'];

        $materi->update([
            'nama_materi'=> $validatedData['nama_materi'],
            'program_id'=> $validatedData['program_id'],
            'menit' => $validatedData['menit'],
            'bobot_persen' => $validatedData['bobot_persen']
        ]);

        return redirect('/materi/'. $id)->with('update',$validatedData['nama_materi']);
        // ada . $id itu untuk mengembalikan ke halaman materi yang id nya sama dengan program sebelumnya diakses
    }

    public function destroyMateri(Request $request, Materi $materi)
    {
        // $program->delete($request);
        // return back()->with('destroy','Deleted Successfully!');

        // dd($materi->id);
        $namaMateri = $materi->nama_materi;
        $idProgram = $materi->program->id;

        if( count(DB::table('assign_teachers')->where('materi_id', $materi->id)->get()) > 0 ){
            return redirect('/materi/' . $idProgram)->with('destroyFailed', $namaMateri);
        }
        
        
       

        // dd($idProgram);
        Materi::find($request->id)->delete();
        // dd($tes);
        // $id = $materi->program_id;
    
        return redirect('/materi/' . $idProgram)->with('destroy', $namaMateri);
        
        
    }

    
}

