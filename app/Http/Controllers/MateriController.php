<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Program;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    // public function index(){
    //     return view('Materi.index', [
    //         'title' => 'Materi'
    //     ]);
    // }

    // public function indexMateri(Request $request, Program $program){

    //     // $materi = Materi::all();

    //     $id = $program->id;

    //     $data = $program->materi;
    //     dd($data);
    //     $search = $request->search;
    //     // $data = Program::all();
    //     // $data = $materi->program;

        
    //     // $dataMateri = $data->where('nama_program','like',"%$search%");
    //     // $dataMateri = $data->where('program_id','=', $id);
        
            
        
        
    //     // $dataMateri = Materi::when($search, function($query, $search, $id){
    //     //     return $query->where('program_id','=', $id);
    //     // })->paginate(5);


    //     // $id  = $materi->program->load('materi')->id;
    //     // dd($materi->program->load('materi')->id);

    //     // $matchThese = ['program_id' => $id];
        
    //     // $results = Materi::where('nama_materi','LIKE', "%{$search}%")
    //     //     ->orWhere('program_id', '=', $id)
    //     //     ->get();
        
    //     // dd($results);
    //     $data = Materi::filter(request(['search']))->Active($id)->paginate(5)->withQueryString();

    //     return view('Materi.index', [
    //         'title' => 'Materi',
    //         'dataProgram' => $program->materi->load('materi'),
    //         'dataMateri' => $data
    //     ]);
    // }

    public function createMateri(Program $program){
        return view('Materi.create', [
            'title' => 'Create',
            'active' => 'Daftar Kurikulum',
            'dataMateri' => $program->load('materi')
        ]);
    }

    public function storeMateri(Request $request, Materi $materi){

        $validatedData = $request->validate([
            'nama_materi'=>'required|between:5,200',
            'program_id'=> 'required|numeric',
            'jumlah_pertemuan' => 'required|numeric|between:1,3',
            'menit' => 'required|numeric|between:30,60',
        ],[
            'nama_materi.required' => 'Silahkan isi terlebih dahulu nama materi',
            'nama_materi.between' => 'Karakter harus berisi setidaknya 1 sampai 3 kata',
            'jumlah_pertemuan.required' => 'Jumlah pertemuan wajib diisi',
            'jumlah_pertemuan.numeric' => 'Jumlah pertemuan wajib diisi dengan angka',
            'jumlah_pertemuan.between' => 'Jumlah pertemuan berisi nilai 1 sampai 3',
            'menit.required' => 'Durasi menit wajib diisi',
            'menit.numeric' => 'Wajib diisi dengan angka',
            'menit.between' => 'Menit diisi dalam rentang 30 dan 60'
        ]);

        
        Materi::create($validatedData);

        $id = $validatedData['program_id'];

        return redirect('/materi/' . $id)->with('success','Create Successfully!');


        
    }
    
    public function showMateri(Materi $materi){

        // $data = Program::where('id', $materi['program_id']);
        $id = $materi['id'];

        return view('Materi.show', [
            'title' => 'Materi',
            'active' => 'Daftar Kurikulum',
            'dataMateri' => $materi->program->load('materi'),
            'id' => $id
        ]);
    }

    public function editMateri(Materi $materi){

        // $data = Program::where('id', $materi['program_id']);
        $id = $materi['id'];

        return view('Materi.update', [
            'title' => 'Materi',
            'active' => 'Daftar Kurikulum',
            'dataMateri' => $materi->program->load('materi'),
            'id' => $id
        ]);
    }

    public function updateMateri(Request $request, Materi $materi){

        // $data = Program::where('id', $materi['program_id']);
        

        // $validatedData = $request->validate([
        //     'nama_materi'=>'required',
        //     'program_id'=> 'required',
        //     'jumlah_pertemuan' => 'required|numeric',
        //     'menit' => 'required|numeric',
        // ]);

        $validatedData = $request->validate([
            'nama_materi'=>'required|between:5,200',
            'program_id'=> 'required|numeric',
            'jumlah_pertemuan' => 'required|numeric|between:1,3',
            'menit' => 'required|numeric|between:30,60',
        ],[
            'nama_materi.required' => 'Silahkan isi terlebih dahulu nama materi',
            'nama_materi.between' => 'Karakter harus berisi setidaknya 1 sampai 3 kata',
            'jumlah_pertemuan.required' => 'Jumlah pertemuan wajib diisi',
            'jumlah_pertemuan.numeric' => 'Jumlah pertemuan wajib diisi dengan angka',
            'jumlah_pertemuan.between' => 'Jumlah pertemuan berisi nilai 1 sampai 3',
            'menit.required' => 'Durasi menit wajib diisi',
            'menit.numeric' => 'Wajib diisi dengan angka',
            'menit.between' => 'Menit diisi dalam rentang 30 dan 60'
        ]);

        $id = $validatedData['program_id'];

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

