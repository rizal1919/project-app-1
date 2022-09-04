<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AktivasiStudent;
use App\Models\Category;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AktivasiController extends Controller
{
    public function index(Request $request){

        $data = Aktivasi::Filter(Request(['search']))->orderByDesc('id')->paginate(5)->withQueryString();
       
        
        foreach( $data as $item ){

            $item['pembukaan'] = date('d M Y', strtotime($item['pembukaan']));
            $item['penutupan'] = date('d M Y', strtotime($item['penutupan']));
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
        $aktivasi['pembukaan'] = date('d M Y', strtotime($aktivasi['pembukaan']));
        $aktivasi['penutupan'] = date('d M Y', strtotime($aktivasi['penutupan']));

        return view('Aktivasi.show', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'dataAktivasi' => $aktivasi
        ]);
    }

    public function create(){

       
        return view('Aktivasi.create', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'categories' => Category::all()
        ]);
    }

    public function program(Request $request){

        $idprogram = $request->id;
        // return $idprogram;

        $data = Category::find($idprogram);
        // cek dulu ada nggak category yang id nya sekian, kalau ada looping, kalau tidak ada maka kembalikan Program Tidak Tersedia
        
        $checkbox = "";
        if($data===null){

            $checkbox.= "<strong>1.  </strong>" . "<input type='checkbox' name='program_id' value='' style='margin-right: 5px; class='form-chech-input' disabled>";
            $checkbox.= "<label for='program' class='form-check-checkbox'>Program Tidak Tersedia</label>";

            echo $checkbox;
        }else{

            $i=1;
            foreach( $data->program as $program ){

                $checkbox.= "<strong>$i.  </strong>" . " <input type='checkbox' id='program_$program->id' style='margin-right: 5px; margin-left: 10px;' name='program_$program->id' value='$program->id' class='form-chech-input'>";
                $checkbox.= "<label for='program_$program->id' class='form-check-checkbox'>$program->nama_program</label><br>";
                $i++;
            }

            echo $checkbox;
        }
    }


    public function store(Request $request){

        
        
        // dd($request->collect());
        $validatedData = $request->validate([
            
            'nama_aktivasi' => 'required',
            'biaya' => 'required',
            'pembukaan' => 'required',
            'penutupan' => 'required'
        ]);

        $checkToday = date('Y-m-d');
        $today = date('d M Y', strtotime($checkToday));
        $opening = date('d M Y', strtotime($validatedData['pembukaan']));
        $closing = date('d M Y', strtotime($validatedData['penutupan']));
        
        if($today >= $opening && $today <= $closing){
            $validatedData['status'] = 'Dibuka';
        }else{
            $validatedData['status'] = 'Ditutup';
        }
        
        Aktivasi::create($validatedData);

        $aktivasi_id = Aktivasi::where('nama_aktivasi', $validatedData['nama_aktivasi'])->first()->id;
        

        if(count($request->collect()) > 6){
            
          

            
            $cek = [];
            $i=0;
            foreach( $request->collect() as $data ){
                
                if( $i>5 ){

                    DB::table('aktivasi_program')->insert([
                        'aktivasi_id' => $aktivasi_id,
                        'program_id' => $data
                    ]);

                
                }

                $i++;
            }

            

        }

        // dd('tes');

        return redirect('/aktivasi')->with('create', $validatedData['nama_aktivasi']);
    }

    public function edit(Aktivasi $aktivasi){

        

        return view('Aktivasi.update', [
            'active' => 'Aktivasi',
            'title' => 'Menu Aktivasi | ',
            'aktivasi' => $aktivasi,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Aktivasi $aktivasi){

        // dd($request->collect());

        $validatedData = $request->validate([

            'nama_aktivasi' => 'required',
            'biaya' => 'required',
            'pembukaan' => 'required',
            'penutupan' => 'required'
        ]);

        $checkToday = date('Y-m-d');
        $today = date('d M Y', strtotime($checkToday));
        $opening = date('d M Y', strtotime($validatedData['pembukaan']));
        $closing = date('d M Y', strtotime($validatedData['penutupan']));
        
        if($today >= $opening && $today <= $closing){
            $validatedData['status'] = 'Dibuka';
        }else{
            $validatedData['status'] = 'Ditutup';
        }

        $aktivasi->update([
            'nama_aktivasi' => $validatedData['nama_aktivasi'],
            'biaya' => $validatedData['biaya'],
            'status' => $validatedData['status'],
            'pembukaan' => $validatedData['pembukaan'],
            'penutupan' => $validatedData['penutupan'],
        ]);


        

        if(count($request->collect()) > 6){
            
            DB::table('aktivasi_program')->where('aktivasi_id', $aktivasi->id)->delete();
            $cek = [];
            $i=0;
            foreach( $request->collect() as $data ){
                
                if( $i>5 ){

                    DB::table('aktivasi_program')->insert([
                        'aktivasi_id' => $aktivasi->id,
                        'program_id' => $data
                    ]);
                }
                $i++;
            }
        }

        return redirect('/aktivasi')->with('update', $validatedData['nama_aktivasi']);
    }

    public function destroy(Aktivasi $aktivasi){

        // dd($aktivasi);

        // $siswaTerdaftar = AktivasiStudent::where('aktivasi_id', $aktivasi->id)->get();
        // dd($siswaTerdaftar);

        // if( count($siswaTerdaftar) > 0 ){
        //     return redirect('/aktivasi')->with('destroyFailed', $aktivasi->nama_aktivasi);
        // }

        // if( count(DB::table('assign_teachers')->where('aktivasi_id', $aktivasi->id)->get()) > 0 ){
        //     return redirect('/aktivasi')->with('destroyFailedAssignment', $aktivasi->nama_aktivasi);
        // }

        DB::table('aktivasi_program')->where('aktivasi_id', $aktivasi->id)->delete();

        Aktivasi::find($aktivasi->id)->delete();

        return redirect('/aktivasi')->with('destroy', $aktivasi->nama_aktivasi);

    }
}
