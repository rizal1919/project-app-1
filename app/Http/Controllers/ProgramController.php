<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Program;
use App\Models\Materi;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request, Kurikulum $kurikulum){

        $data = Program::where('kurikulum_id', '=', $kurikulum->id)->Filter(request(['search']))->paginate(5)->withQueryString();
       
        return view('Program.index', [
            'title' => 'Programs',
            'active' => 'Data Kurikulum',
            'programs' => $data,
            'kurikulum' => $kurikulum
        ]);
    }

    public function indexMateri(Request $request, Program $program){

        // dd($program->materi());

        // $id = $program->materi;
        $id = $program->id;
        // dd($id);


        // $data = Materi::Active($id)->paginate(5)->withQueryString();
        $data = Materi::filter(request(['search']))->Active($id)->paginate(5)->withQueryString();


        // dd($data);
        return view('Materi.index', [
            'title' => 'Materi',
            'active' => 'Data Kurikulum',
            'dataProgram' => $program,
            'dataMateri' => $data
        ]);

    }


    public function create(Kurikulum $kurikulum){

        return view('Program.create', [
            'title' => 'Create',
            'active' => 'Data Kurikulum',
            'kurikulum' => $kurikulum
        ]);
    }

    public function store(Request $request){


        $validatedData = $request->validate([
            'nama_program' => 'required',
            'kurikulum_id' => 'required'
        ]);

        Program::create($validatedData);

        return redirect('/program/' . $validatedData['kurikulum_id'])->with('create',$validatedData['nama_program']);
    }

    public function show(Program $program){
       
        return view('Program.show', [
            'title' => $program->nama_program,
            'active' => 'Data Kurikulum',
            'programs' => $program
        ]);
    }

    public function edit(Program $program){

        $dataKurikulum = Kurikulum::where('id', '=', $program->kurikulum_id)->first();
        // dd($dataKurikulum);



        return view('Program.update', [
            'title'=> 'Update',
            'active' => 'Data Kurikulum',
            'programs' => $program,
            'kurikulum' => $dataKurikulum
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $validatedData = $request->validate([
            'nama_program'=>'required',
            'kurikulum_id' => 'required'
        ]);

        // dd($validatedData);
        $program->update([
            'nama_program' => $validatedData['nama_program'],
            'kurikulum_id' => $validatedData['kurikulum_id'],
        ]);

        return redirect('/program/' . $validatedData['kurikulum_id'])->with('update',$validatedData['nama_program']);
    }

    public function destroy(Request $request, Program $program)
    {
        // $program->delete($request);
        // return back()->with('destroy','Deleted Successfully!');
        $aktivasiProgram = $program->aktivasi;
        if( count($aktivasiProgram) > 0 ){
            return redirect('/program/' . $program->kurikulum_id)->with('destroyFailed', $program->nama_program);
        }
        
        Program::find($program->id)->delete();
    
        return redirect('/program/' . $program->kurikulum_id)->with('destroy', $program->nama_program);
        
        
    }
}
