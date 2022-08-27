<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AktivasiStudent;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AktivasiController extends Controller
{
    public function index(Request $request){

        $data = Aktivasi::Filter(Request(['search']))->orderByDesc('id')->paginate(5)->withQueryString();
       
        // $data['biaya'] = "Rp" . number_format($data['biaya'], 2, ",", ".");
        foreach( $data as $item ){

            $item['biaya'] = "Rp" . number_format($item['biaya'], 2, ",", ".");
        }

        return view('Aktivasi.index', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'aktivasi' => $data,
           
        ]);
    }

    public function show(Aktivasi $aktivasi){

        

            $aktivasi['biaya'] = "Rp" . number_format($aktivasi['biaya'], 2, ",", ".");
        


        return view('Aktivasi.show', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'dataAktivasi' => $aktivasi
        ]);
    }

    public function create(){

        $data = Program::all();
        

        return view('Aktivasi.create', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'programs' => $data
        ]);
    }

    public function store(Request $request){

        // dd($request['program_id']);

        if($request['program_id'] == 0 || $request['status'] == 0){
            // dd('yepii');
            return redirect('/create-aktivasi')->with('pendaftaranGagal', 'Nama Program / Status Aktivasi');
        }

        $validatedData = $request->validate([

            'nama_aktivasi' => 'required',
            'biaya' => 'required',
            'program_id' => 'required',
            'status' => 'required',
            'periode' => 'required'
        ]);
        
        Aktivasi::create($validatedData);

        return redirect('/aktivasi')->with('create', $validatedData['nama_aktivasi']);
    }

    public function edit(Aktivasi $aktivasi){

        

        return view('Aktivasi.update', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'aktivasi' => $aktivasi,
            'programs' => Program::all()
        ]);
    }

    public function update(Request $request, Aktivasi $aktivasi){

        // dd($request->collect());

        $validatedData = $request->validate([

            'nama_aktivasi' => 'required',
            'biaya' => 'required',
            'program_id' => 'required',
            'status' => 'required',
            'periode' => 'required'
        ]);

        if( $validatedData['status'] == 0 ){

            return redirect('/update-aktivasi-program/' . $request->id)->with('gagal', $validatedData['nama_aktivasi']);
        }

        $aktivasi->update([
            'nama_aktivasi' => $validatedData['nama_aktivasi'],
            'biaya' => $validatedData['biaya'],
            'program_id' => $validatedData['program_id'],
            'status' => $validatedData['status'],
            'periode' => $validatedData['periode']
        ]);

        return redirect('/update-aktivasi-program/' . $request->id)->with('sukses', $validatedData['nama_aktivasi']);

        
    }

    public function destroy(Aktivasi $aktivasi){

        // dd($aktivasi);

        $siswaTerdaftar = AktivasiStudent::where('aktivasi_id', $aktivasi->id)->get();
        // dd($siswaTerdaftar);

        if( count($siswaTerdaftar) > 0 ){
            return redirect('/aktivasi')->with('destroyFailed', $aktivasi->nama_aktivasi);
        }

        if( count(DB::table('assign_teachers')->where('aktivasi_id', $aktivasi->id)->get()) > 0 ){
            return redirect('/aktivasi')->with('destroyFailedAssignment', $aktivasi->nama_aktivasi);
        }

        Aktivasi::find($aktivasi->id)->delete();

        return redirect('/aktivasi')->with('destroy', $aktivasi->nama_aktivasi);

    }
}
