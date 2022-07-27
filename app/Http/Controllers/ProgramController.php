<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Materi;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request){

        $programs = Program::all();
        $search = $request->search;
        $programs = Program::when($search, function($query, $search){
            return $query->where('nama_program','like',"%$search%");
        })->paginate(5);

        // if( request('search') ){
        //     $programs = Program::when($search, function($query, $search){
        //         return $query->where('nama_program','like',"%$search%");
        //     })->paginate(5);
        // }

        // if( request('search') ){
        //     $programs = Program::where('nama_program', 'like', "%$search%")->get();
        // }

        return view('Program.index', [
            'title' => 'Programs',
            'active' => 'Daftar Kurikulum',
            'programs' => $programs
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
            'active' => 'Daftar Kurikulum',
            'dataProgram' => $program,
            'dataMateri' => $data
        ]);

    }


    public function create(Program $program){
        return view('Program.create', [
            'title' => 'Create',
            'active' => 'Daftar Kurikulum',
            'programs' => $program
        ]);
    }

    public function store(Request $request, Program $program){

        $validatedData = $request->validate([
            'nama_program' => 'required|unique:programs|between:3,100'
        ]);

        Program::create($validatedData);

        return redirect('/program')->with('create','Create Successfully!');
    }

    public function show(Program $program){
        return view('Program.show', [
            'title' => 'Read',
            'active' => 'Daftar Kurikulum',
            'programs' => $program
        ]);
    }

    public function edit(Program $program){

        return view('Program.update', [
            'title'=> 'Update',
            'active' => 'Daftar Kurikulum',
            'programs' => $program
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $validatedData = $request->validate([
            'nama_program'=>'required|between:3,100',
        ]);

        $program->update([
            'nama_program' => $validatedData['nama_program'],
        ]);

        return redirect('/program')->with('update','Update Successfully!');
    }

    public function destroy(Request $request, Program $program)
    {
        // $program->delete($request);
        // return back()->with('destroy','Deleted Successfully!');

        
        Program::find($program->id)->delete();
    
        return redirect('/program')->with('destroy', 'Deleted Successfully!');
        
        
    }
}
