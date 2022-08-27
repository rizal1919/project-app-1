<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\KurikulumStudent;
use App\Models\Student;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    

    public function index(Request $request){

        // $kurikulums = Kurikulum::all();
        // $search = $request->search;
        // $kurikulums = Kurikulum::when($search, function($query, $search){
        //     return $query->where('nama_kurikulum','like',"%$search%");
        // })->paginate(5);

        $kurikulums = Kurikulum::Filter(Request(['search']))->paginate(5)->withQueryString();

        foreach( $kurikulums as $item ){

            $item['biaya'] = "Rp" . number_format($item['biaya'], 2, ",", ".");
        }

        return view('Kurikulum.index', [
            'title' => 'Kurikulum | ',
            'active' => 'Data Kurikulum',
            'kurikulums' => $kurikulums
        ]);
    }

    public function create(){


        return view('Kurikulum.create', [
            'title' => 'Kurikulum | ',
            'active' => 'Data Kurikulum'
        ]);
    }

    public function store(Request $request){

        // dd($request->collect());
        
        $validatedData = $request->validate([

            'nama_kurikulum' => 'required|max:255',
            'biaya' => 'required'
        ],[
            'nama_kurikulum.required' => 'nama kurikulum harus diisi',
            'nama_kurikulum.max' => 'maksimal karakter adalah 255',
            'biaya.required' => 'biaya wajib diisi'
        ]);

        // dd($validatedData);

        Kurikulum::create($validatedData);

        return redirect('/kurikulum')->with('create', $validatedData['nama_kurikulum']);
    }

    public function show(Kurikulum $kurikulum){


        $dataKurikulum = Kurikulum::where('id', $kurikulum->id)->first();

        

        $dataKurikulum['biaya'] = "Rp" . number_format($dataKurikulum['biaya'], 2, ",", ".");
        
        return view('Kurikulum.show',[

            'title' => 'Kurikulum | ',
            'active' => 'Data Kurikulum',
            'kurikulums' => $dataKurikulum
        ]);
    }

    public function edit(Kurikulum $kurikulum){


        

        // dd($dataKurikulum);

        return view('Kurikulum.update',[

            'title' => 'Kurikulum | ',
            'active' => 'Data Kurikulum',
            'kurikulum' => $kurikulum
        ]);
    }

    public function update(Request $request, Kurikulum $kurikulum){


        $validatedData = $request->validate([

            'nama_kurikulum' => 'required|max:255',
            'biaya' => 'required'
            
        ]);

        $kurikulum->update([
            'nama_kurikulum' => $validatedData['nama_kurikulum'],
            'biaya' => $validatedData['biaya']
            
        ]);

        return redirect('/kurikulum')->with('update', $validatedData['nama_kurikulum']);
    }

    public function destroy(Kurikulum $kurikulum){

        
        $siswaTerdaftar = KurikulumStudent::where('kurikulum_id', $kurikulum->id)->get();
        
        if( count($siswaTerdaftar) > 0 ){
            return redirect('/kurikulum')->with('destroyFailed', $kurikulum->nama_kurikulum);
        }

        Kurikulum::find($kurikulum->id)->delete();
    
        return redirect('/kurikulum')->with('destroy', $kurikulum->nama_kurikulum);
    }
}
