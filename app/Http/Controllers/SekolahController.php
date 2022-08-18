<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index(Request $request){

        $data = Sekolah::Filter(request(['nama_sekolah']))->orderBy('id', 'desc')->paginate(3)->withQueryString();
        // dd($data);

        return view('Sekolah.index', [

            'title' => 'Sekolah | ',
            'active' => 'Sekolah',
            'dataSekolah' => $data
        ]);
    }

    public function create(){

        return view('Sekolah.create', [

            'title' => 'Sekolah | ',
            'active' => 'Sekolah'
        ]);
    }

    public function store(Request $request){

        // dd($request->nama_sekolah);

        $validatedData = $request->validate([

            'nama_sekolah' => 'required',
            'alamat' => 'required'
        ]);

        Sekolah::create($validatedData);

        return redirect('/sekolah')->with('create', $validatedData['nama_sekolah']);
    }

    public function show(Sekolah $sekolah){

        

        return view('Sekolah.show', [
            'title' => 'Sekolah | ',
            'active' => 'Sekolah',
            'dataSekolah' => $sekolah
        ]);
    }

    public function edit(Sekolah $sekolah){

        return view('Sekolah.update', [

            'title' => 'Sekolah | ',
            'active' => 'Sekolah',
            'dataSekolah' => $sekolah
        ]);
    }

    public function update(Request $request, Sekolah $sekolah){

        // dd($request->collect());

        $validatedData = $request->validate([

            'nama_sekolah' => 'required',
            'alamat' => 'required'
        ]);

        $sekolah->update([
            'nama_sekolah' => $validatedData['nama_sekolah'],
            'alamat' => $validatedData['alamat']
        ]);

        return redirect('/sekolah')->with('update', $validatedData['nama_sekolah']);


    }

    public function delete(Sekolah $sekolah){

        Sekolah::find($sekolah->id)->delete();

        return redirect('/sekolah')->with('delete', $sekolah->nama_sekolah);
    }
}
