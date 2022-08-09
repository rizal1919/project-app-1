<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use Illuminate\Http\Request;

class AktivasiController extends Controller
{
    public function index(Request $request){

        $data = Aktivasi::Filter(Request(['search']))->orderByDesc('id')->paginate(5)->withQueryString();

        

        return view('Aktivasi.index', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'aktivasi' => $data
        ]);
    }

    public function show(){



        return view('Aktivasi.show', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | '
        ]);
    }

    public function create(){

        return view('Aktivasi.create', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | '
        ]);
    }

    public function store(Request $request){

        // dd($request->collect());

        $validatedData = $request->validate([

            'nama_aktivasi' => 'required',
            'harga' => 'required',
            'program' => 'required',
            'status' => 'required',
            'periode' => 'required'
        ]);

        
        Aktivasi::create($validatedData);

        return redirect('/create-aktivasi')->with('sukses', $validatedData['nama_aktivasi']);
    }

    public function edit(Aktivasi $aktivasi){

        

        return view('Aktivasi.update', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'aktivasi' => $aktivasi
        ]);
    }

    public function update(Request $request, Aktivasi $aktivasi){

       

        $validatedData = $request->validate([

            'nama_aktivasi' => 'required',
            'harga' => 'required',
            'program' => 'required',
            'status' => 'required',
            'periode' => 'required'
        ]);

        if( $validatedData['status'] == '0' ){

            return redirect('/update-aktivasi-program/' . $request->id)->with('gagal', $validatedData['nama_aktivasi']);
        }

        $aktivasi->update([
            'nama_aktivasi' => $validatedData['nama_aktivasi'],
            'harga' => $validatedData['harga'],
            'program' => $validatedData['program'],
            'status' => $validatedData['status'],
            'periode' => $validatedData['periode']
        ]);

        return redirect('/update-aktivasi-program/' . $request->id)->with('sukses', $validatedData['nama_aktivasi']);

        
    }

    public function destroy(Aktivasi $aktivasi){

       

        Aktivasi::find($aktivasi->id)->delete();

        return redirect('/aktivasi')->with('destroy', $aktivasi->nama_aktivasi);

    }
}
