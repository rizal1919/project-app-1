<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Kurikulum;
use App\Models\Program;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function index(Request $request){

        $data = Program::Filter(request(['search']))->paginate(5)->withQueryString();
       
        return view('Program.index', [
            'title' => 'Program',
            'active' => 'Program',
            'programs' => $data
        ]);
    }

    

    public function create(){


        return view('Program.create', [
            'title' => 'Program',
            'active' => 'Program'
        ]);
    }

    public function store(Request $request){

       
        $validatedData = $request->validate([
            'nama_program' => 'required'
        ]);

        Program::create($validatedData);

        return redirect('/program')->with('create',$validatedData['nama_program']);
    }

    public function show(Program $program){
       
        return view('Program.show', [
            'title' => 'Program',
            'active' => 'Program',
            'programs' => $program
        ]);
    }

    public function edit(Program $program){

        return view('Program.update', [
            'title'=> 'Program',
            'active' => 'Program',
            'programs' => $program
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $validatedData = $request->validate([
            'nama_program'=>'required'
        ]);

        // dd($validatedData);
        $program->update([
            'nama_program' => $validatedData['nama_program']
        ]);

        return redirect('/program')->with('update',$validatedData['nama_program']);
    }

    public function destroy(Request $request, Program $program)
    {
        
        

        if( $program->aktivasi->isNotEmpty()){
            return redirect('/program')->with('destroyFailed', $program->nama_program);
        }
        
        Program::find($program->id)->delete();
    
        return redirect('/program')->with('destroy', $program->nama_program);
        
        
    }
}
