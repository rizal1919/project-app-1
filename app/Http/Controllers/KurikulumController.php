<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    

    public function index(Request $request){

        $kurikulums = Kurikulum::all();
        $search = $request->search;
        $kurikulums = Kurikulum::when($search, function($query, $search){
            return $query->where('nama_kurikulum','like',"%$search%");
        })->paginate(5);

        return view('Kurikulum.index', [
            'title' => 'Kurikulum | ',
            'active' => 'Daftar Kurikulum',
            'kurikulums' => $kurikulums
        ]);
    }

    public function create(){


        return view('Kurikulum.create', [
            'title' => 'Kurikulum | ',
            'active' => 'Daftar Kurikulum'
        ]);
    }

    public function store(Request $request){

        // dd($request);
        
        $validatedData = $request->validate([

            'nama_kurikulum' => 'required|max:255'
        ],[
            'nama_kurikulum.required' => 'nama kurikulum harus diisi',
            'nama_kurikulum.max' => 'maksimal karakter adalah 255'
        ]);

        // dd($validatedData);

        Kurikulum::create($validatedData);

        return redirect('/kurikulum')->with('create', 'Berhasil!');
    }

    public function show(Kurikulum $kurikulum){


        $dataKurikulum = Kurikulum::where('id', $kurikulum->id)->first();

        // dd($dataKurikulum);

        return view('Kurikulum.show',[

            'title' => 'Kurikulum | ',
            'active' => 'Data Kurikulum',
            'kurikulums' => $dataKurikulum
        ]);
    }

    public function edit(Kurikulum $kurikulum){


        $dataKurikulum = Kurikulum::where('id', $kurikulum->id)->first();

        // dd($dataKurikulum);

        return view('Kurikulum.update',[

            'title' => 'Kurikulum | ',
            'active' => 'Data Kurikulum',
            'kurikulums' => $dataKurikulum
        ]);
    }

    public function update(Request $request, Kurikulum $kurikulum){


        $validatedData = $request->validate([

            'nama_kurikulum' => 'required|max:255'
        ]);

        $kurikulum->update([
            'nama_kurikulum' => $validatedData['nama_kurikulum']
        ]);

        return redirect('/kurikulum')->with('update', 'Berhasil! ');
    }

    public function destroy(Kurikulum $kurikulum){

        Kurikulum::find($kurikulum->id)->delete();
        // Materi::firstWhere('id', $materi->id);
        // $id = $materi->program_id;
    
        return redirect('/kurikulum')->with('destroy', 'Berhasil!');
    }
}
