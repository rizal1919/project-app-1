<?php

namespace App\Http\Controllers;

use App\Models\PIC;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class PICController extends Controller
{
    public function index(Request $request){

        $data = PIC::Filter(request(['nama_pic']))->orderBy('id', 'desc')->paginate(3)->withQueryString();
        // dd($data);

        return view('PIC.index', [

            'title' => 'PIC | ',
            'active' => 'PIC',
            'dataPIC' => $data
        ]);
    }

    public function create(){

        return view('PIC.create', [

            'title' => 'PIC | ',
            'active' => 'PIC',
            'dataSekolah' => Sekolah::all()
        ]);
    }

    public function store(Request $request){

        // dd($request->nama_sekolah);

        $validatedData = $request->validate([

            'nama_pic' => 'required',
            'kode_referral' => 'required',
            'nomor_telepon' => 'required',
            'sekolah_id' => 'required'
        ]);

        PIC::create($validatedData);

        return redirect('/pic')->with('create', $validatedData['nama_pic']);
    }

    public function show(PIC $pic){

        // dd($pic->sekolah->nama_sekolah);

        return view('PIC.show', [
            'title' => 'PIC | ',
            'active' => 'PIC',
            'dataPIC' => $pic
        ]);
    }

    public function edit(PIC $pic){

        // dd($pic);

        return view('PIC.update', [

            'title' => 'PIC | ',
            'active' => 'PIC',
            'dataPIC' => $pic,
            'dataSekolah' => Sekolah::all()
        ]);
    }

    public function update(Request $request, PIC $pic){

        // dd($request->collect());

        $validatedData = $request->validate([

            'nama_pic' => 'required',
            'kode_referral' => 'required',
            'nomor_telepon' => 'required',
            'sekolah_id' => 'required'
        ]);

        $pic->update([
            'nama_pic' => $validatedData['nama_pic'],
            'kode_referral' => $validatedData['kode_referral'],
            'nomor_telepon' => $validatedData['nomor_telepon'],
            'sekolah_id' => $validatedData['sekolah_id']
        ]);

        return redirect('/pic')->with('update', $validatedData['nama_pic']);


    }

    public function delete(PIC $pic){

        PIC::find($pic->id)->delete();

        return redirect('/pic')->with('delete', $pic->nama_pic);
    }
}
