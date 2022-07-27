<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Student;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function index(){

        $programs = Program::all();
        
        $nomorUrut = Student::all()->last();

        $year = date("Y")[3] . date("Y")[2];
        // $nomorUrut = '00129';
        if($nomorUrut === null){
            $hasilAkhirNoUrut = '00001' . $year;
            // dd($hasilAkhirNoUrut);
        }else{
            
            // $str = (string)$nomorUrut;
            // $tes = $str[4];
           

            $array = [];
            for ($i=0; $i < 5; $i++) { 
                
                if( $nomorUrut[$i] == 0 ){
                    continue;
                }
                $array[] = $nomorUrut[$i];
            }

            $str = join("",$array);
            $int = (int)$str;
            $result = $int+1;
            $str = (string)$result;
            $length = count($array);
            
            if( $length == 1 ){
                $hasilAkhirNoUrut = '0000' . $str . $year;
            }elseif( $length == 2 ){
                $hasilAkhirNoUrut = '000' . $str . $year;
            }elseif( $length == 3 ){
                $hasilAkhirNoUrut = '00' . $str . $year;
            }elseif( $length == 4 ){
                $hasilAkhirNoUrut = '0' . $str . $year;
            }elseif( $length == 5 ){
                $hasilAkhirNoUrut = $str . $year;
            }

            
            $hasilAkhirNoUrut;
        
        }


        return view('Pendaftaran.index', [

            'title' => 'Pendaftaran',
            'active' => 'Pendaftaran',
            'nomor' => $hasilAkhirNoUrut,
            'programs' => $programs,
            'count' => count($programs),
            'year' => $year
        ]);
    }
}
