<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Program;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index(){
        return view('Materi.index', [
            'title' => 'Materi'
        ]);
    }

    public function indexMateri(Materi $materi){

        return view('Materi.index', [
            'title' => 'Materi',
            'dataMateri' =>  $materi->program->load('materi'),
        ]);
    }
    
    public function showMateri(Materi $materi){

        // $data = Program::where('id', $materi['program_id']);
        $id = $materi['id'];

        return view('Materi.show', [
            'title' => 'Materi',
            'dataMateri' => $materi->program->load('materi'),
            'id' => $id
        ]);
    }

    public function editMateri(Materi $materi){

        // $data = Program::where('id', $materi['program_id']);
        $id = $materi['id'];

        return view('Materi.update', [
            'title' => 'Materi',
            'dataMateri' => $materi->program->load('materi'),
            'id' => $id
        ]);
    }

    public function updateMateri(Request $request, Materi $materi){

        // $data = Program::where('id', $materi['program_id']);
        

        $validatedData = $request->validate([
            'nama_materi'=>'required',
            'program_id'=> 'required',
            'jumlah_pertemuan' => 'required|numeric',
            'menit' => 'required|numeric',
            'id_program_besar' => 'required'
        ]);

        $id = $validatedData['id_program_besar'];
        $dataMateri = $materi->program->load('materi');

        $materi->update([
            'nama_materi'=> $validatedData['nama_materi'],
            'program_id'=> $validatedData['program_id'],
            'jumlah_pertemuan' => $validatedData['jumlah_pertemuan'],
            'menit' => $validatedData['menit']
        ]);

        return redirect('/materi/'. $id)->with('update','Update Successfully!');
        // ada . $id itu untuk mengembalikan ke halaman materi yang id nya sama dengan program sebelumnya diakses
    }

    public function destroyMateri(Materi $materi)
    {
        // $program->delete($request);
        // return back()->with('destroy','Deleted Successfully!');
        
        
        Materi::find($materi->id)->delete();
        // Materi::firstWhere('id', $materi->id);
        $id = $materi->program_id;
    
        return redirect('/materi/' . $id)->with('destroy', 'Deleted Successfully!');
        
        
    }
}

