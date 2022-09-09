<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AktivasiStudent;
use App\Models\CicilanAktivasiStudent;
use App\Models\CicilanKurikulumStudent;
use App\Models\Kurikulum;
use App\Models\Kurikulum_Student;
use App\Models\KurikulumStudent;
use App\Models\Program;
use App\Models\Student;
use App\Models\UserAdmin;
use App\Models\Collection;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

use function GuzzleHttp\Promise\all;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {

        $dataAktivasi = Aktivasi::all();
        if($dataAktivasi->count() > 0){

            $rakSementara = [];
            foreach( $dataAktivasi as $aktivasi ){

                if( $aktivasi->student->count() > 0 ){

                    foreach( $aktivasi->student as $student ){

                        $status = '';
                        foreach( $student->installment as $installment ){

                            if( $installment->status == 'Belum Lunas' ){

                                $status = 'Belum Lunas';
                                break;
                            }else{
                                $status = 'Lunas';
                            }
                        }

                        $rak = [
                            'idStudent' => $student->id,
                            'studentName' => $student->nama_siswa,
                            'activationName' => $aktivasi->nama_aktivasi,
                            'studentStatus' => 'On Going',
                            'payment' => $status
                        ];

                        array_push($rakSementara, $rak);
                    }
                }

            }

            
        }
    



        $rakSemuaHasilData = (new Collection($rakSementara))->paginate(5)->withQueryString();
        // dapet code di atas dari sini -> https://gist.github.com/simonhamp/549e8821946e2c40a617c85d2cf5af5e
        // kemudian bikin file Collection.php di models
        // ganti namespace nya jadi App\Models, kemudian panggil library nya use App\Models\Collection;
        // kemudian cara pakei nya seperti eloquent




        return view('Pendaftaran.index', [

            'title' => 'Pendaftaran',
            'active' => 'Pendaftaran',
            'dataSiswa' => $rakSemuaHasilData

        ]);
    }


    public function create()
    {
        $date = date("Y-m-d");


        return view('Pendaftaran.create', [

            'active' => 'Pendaftaran',
            'title' => 'Tambah Reguler | ',
            'aktivasis' => Aktivasi::all(),
            'date' => $date,
            'students' => Student::all()
        ]);
    }

    public function getStudent(Request $request){

        if( $request->nama_siswa ){

            $data = Student::where('nama_siswa', $request->nama_siswa)->get();
            return $data;
        }
    }

    public function getPayment(Request $request){

        if($request->metode){
            
            $data = Aktivasi::find($request->aktivasi_id);
            $day = date('d');

            // buat kondisi agar selalu jatuh pada tanggal 10 secara default
            if( $day < 10 ){
                $selisihHari = 10-$day;
                $day= $day + $selisihHari;
            }elseif( $day > 10 ){
                $selisihHari = $day-10;
                $day= $day - $selisihHari;
            }

            // mencari waktu hari ini
            $month = date('m');
            $year = date('Y');
            $hour = date('H');
            $minutes = date('i');
            $seconds = date('s');

           
            $hasilDibulatkan = strval(round($data->biaya/(int)$request->metode));
            $hasilBiaya = explode(',', $hasilDibulatkan)[0];

           
            $rincianBiaya = [];
            if( $request->metode === '1' ){

                $biaya = "Rp" . number_format($hasilBiaya, 2, ",", ".");
                $jadwal = date('d/m/Y', mktime($hour, $minutes, $seconds, $month+1, $day, $year));
               
                $box = "<ul>";
                $box .= "<li>$biaya</li>";
                $box .= "<li>Pembayaran Tunai harus dibayarkan paling lambat tanggal $jadwal</li>";
                $box .= "<li>Perubahan tanggal pembayaran harus melalui persetujuan supervisor</li>";
                $box .= "</ul>";

                $array = [
                    'tanggal' => $jadwal,
                    'nama_cicilan' => 'Tunai',
                    'biaya' => "Rp" . number_format($data->biaya, 2, ",", "."),
                    'status' => 'Belum lunas'
                ];

                array_push($rincianBiaya, $array);
            }elseif( $request->metode == 2 ){

                $biayaCicilan = "Rp" . number_format($hasilBiaya, 2, ",", ".");
                $metode = $request->metode;
                $biayaTotal = "Rp" . number_format($data->biaya, 2, ",", ".");
                $jadwal = date('d', mktime($hour, $minutes, $seconds, $month+1, $day, $year));
               
                $box = "<ul>";
                $box .= "<li>$biayaTotal</li>";
                $box .= "<li>Pembayaran sejumlah $biayaCicilan selama " . "$metode" . "x harus dibayarkan paling lambat tanggal $jadwal</li>";
                $box .= "<li>Perubahan tanggal pembayaran harus melalui persetujuan supervisor</li>";
                $box .= "</ul>";
                
                for($i=1; $i<=$request->metode; $i++ ){
                    
                    $schedule = date('d M Y', mktime($hour, $minutes, $seconds, $month+$i, $day, $year));
                    $array = [
                        'tanggal' => $schedule,
                        'nama_cicilan' => 'Cicilan ' . $i,
                        'biaya' => "Rp" . number_format($hasilBiaya, 2, ",", "."),
                        'status' => 'Belum lunas'
                    ];

                    array_push($rincianBiaya, $array);

                }

            }elseif( $request->metode == 3 ){

                
                $biayaCicilan = "Rp" . number_format($hasilBiaya, 2, ",", ".");
                $metode = $request->metode;
                $biayaTotal = "Rp" . number_format($data->biaya, 2, ",", ".");
                $jadwal = date('d', mktime($hour, $minutes, $seconds, $month+1, $day, $year));
               
                $box = "<ul>";
                $box .= "<li>$biayaTotal</li>";
                $box .= "<li>Pembayaran sejumlah $biayaCicilan selama " . "$metode" . "x harus dibayarkan paling lambat tanggal $jadwal</li>";
                $box .= "<li>Perubahan tanggal pembayaran harus melalui persetujuan supervisor</li>";
                $box .= "</ul>";
                
                for($i=1; $i<=$request->metode; $i++ ){
                    
                    $schedule = date('d M Y', mktime($hour, $minutes, $seconds, $month+$i, $day, $year));
                    $array = [
                        'tanggal' => $schedule,
                        'nama_cicilan' => 'Cicilan ' . $i,
                        'biaya' => "Rp" . number_format($hasilBiaya, 2, ",", "."),
                        'status' => 'Belum lunas'
                    ];

                    array_push($rincianBiaya, $array);

                }

            }elseif( $request->metode == 5 ){

                
                $biayaCicilan = "Rp" . number_format($hasilBiaya, 2, ",", ".");
                $metode = $request->metode;
                $biayaTotal = "Rp" . number_format($data->biaya, 2, ",", ".");
                $jadwal = date('d', mktime($hour, $minutes, $seconds, $month+1, $day, $year));
               
                $box = "<ul>";
                $box .= "<li>$biayaTotal</li>";
                $box .= "<li>Pembayaran sejumlah $biayaCicilan selama " . "$metode" . "x harus dibayarkan paling lambat tanggal $jadwal</li>";
                $box .= "<li>Perubahan tanggal pembayaran harus melalui persetujuan supervisor</li>";
                $box .= "</ul>";

                for($i=1; $i<=$request->metode; $i++ ){
                    
                    $schedule = date('d M Y', mktime($hour, $minutes, $seconds, $month+$i, $day, $year));
                    $array = [
                        'tanggal' => $schedule,
                        'nama_cicilan' => 'Cicilan ' . $i,
                        'biaya' => "Rp" . number_format($hasilBiaya, 2, ",", "."),
                        'status' => 'Belum lunas'
                    ];

                    array_push($rincianBiaya, $array);

                }
                
            }elseif( $request->metode == 6 ){

                
                $biayaCicilan = "Rp" . number_format($hasilBiaya, 2, ",", ".");
                $metode = $request->metode;
                $biayaTotal = "Rp" . number_format($data->biaya, 2, ",", ".");
                $jadwal = date('d', mktime($hour, $minutes, $seconds, $month+1, $day, $year));
               
                $box = "<ul>";
                $box .= "<li>$biayaTotal</li>";
                $box .= "<li>Pembayaran sejumlah $biayaCicilan selama " . "$metode" . "x harus dibayarkan paling lambat tanggal $jadwal</li>";
                $box .= "<li>Perubahan tanggal pembayaran harus melalui persetujuan supervisor</li>";
                $box .= "</ul>";


                for($i=1; $i<=$request->metode; $i++ ){
                    
                    $schedule = date('d M Y', mktime($hour, $minutes, $seconds, $month+$i, $day, $year));
                    $array = [
                        'tanggal' => $schedule,
                        'nama_cicilan' => 'Cicilan ' . $i,
                        'biaya' => "Rp" . number_format($hasilBiaya, 2, ",", "."),
                        'status' => 'Belum lunas'
                    ];

                    array_push($rincianBiaya, $array);

                }

            }


            $table = "<tr>";
            $i=1;
            foreach( $rincianBiaya as $rincian ){

                $tanggal = $rincian['tanggal'];
                $status = $rincian['status'];
                $nama_cicilan = $rincian['nama_cicilan'];
                $biaya = $rincian['biaya'];

                $table .= "<td>$i</td>";
                $table .= "<td>$tanggal</td>";
                $table .= "<td>$nama_cicilan</td>";
                $table .= "<td>$biaya</td>";
                $table .= "<td>$status</td>";

                $table .= "</tr>";

                $i++;
            }

            $boxBesar = [
                'table' => $table,
                'boxDetail' => $box
            ];

            return $boxBesar;


        }
    }

    

    public function store(Request $request)
    {

        $data = $request->collect();

        // dd($data);

        
        $validatedData = $request->validate([
            'student_id' => 'required',
            'aktivasi_id' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required',
            'ktp' => 'required',
            'metode_pembayaran' => 'required'
        ]);

        // dd($validatedData);
        
        $day = date('d');

        // buat kondisi agar selalu jatuh pada tanggal 10 secara default
        if( $day < 10 ){
            $selisihHari = 10-$day;
            $day= $day + $selisihHari;
        }elseif( $day > 10 ){
            $selisihHari = $day-10;
            $day= $day - $selisihHari;
        }

        // mencari waktu hari ini
        $month = date('m');
        $year = date('Y');
        $hour = date('H');
        $minutes = date('i');
        $seconds = date('s');

        
        $totalBiaya = Aktivasi::find($validatedData['aktivasi_id'])->biaya;
        $biayaPembulatan = strval(round($totalBiaya/(int)$validatedData['metode_pembayaran']));
        $biayaAkhir = explode(',',$biayaPembulatan)[0];

        
        

        for( $i=1; $i<=$validatedData['metode_pembayaran']; $i++ ){

            $schedule = date('Y-m-d', mktime($hour, $minutes, $seconds, $month+$i, $day, $year));

            Installment::create([
                'aktivasi_id' => $validatedData['aktivasi_id'],
                'student_id' => $validatedData['student_id'],
                'installment' => $biayaAkhir,
                'paid' => 0,
                'status' => 'Belum Lunas',
                'date_payment' => $schedule,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        DB::table('aktivasi_student')->insert([
            'aktivasi_id' => $validatedData['aktivasi_id'],
            'student_id' => $validatedData['student_id']
        ]);

        $nama_siswa = Student::find($validatedData['student_id'])->nama_siswa;
        

        return redirect('/form-registrasi')->with('pendaftaranBerhasil', $nama_siswa);
    }



    public function softDeleteStudent($nama, $id, $namaSiswa)
    {

        // dd($namaSiswa);
        if (stripos($nama, 'Reguler') === false) {


            // AktivasiStudent::find($id)->delete();
        } elseif (stripos($nama, 'Reguler') === 0) {


            // KurikulumStudent::find($id)->delete();
        }


        return redirect('/form-registrasi')->with('destroy', $namaSiswa);
    }

    // public function restoreStudent($nama, $id, $namaSiswa)
    // {
    //     // dd($namaSiswa);
    //     if (stripos($nama, 'Reguler') === false) {

    //         AktivasiStudent::withTrashed()->find($id)->restore();
    //     } elseif (stripos($nama, 'Reguler') === 0) {

    //         KurikulumStudent::withTrashed()->find($id)->restore();
    //     }

    //     return redirect('/form-registrasi')->with('restore', $namaSiswa);
    // }

    public function indexCost($id, $namaProgram){

        // $dataAktivasi = Aktivasi::all();
        // $dataKurikulum = Kurikulum::all();
        // $cicilanAktivasi = DB::table('cicilan_aktivasi_students')->where('aktivasi_student', $id)->get();
        // $cicilanKurikulum = DB::table('cicilan_kurikulum_students')->where('kurikulum_student', $id)->get();
        
        // if (stripos($namaProgram, 'Reguler') === false) {

        //     // $idStudent = AktivasiStudent::find($id)->student_id;
        //     $namaStudent = Student::find($idStudent)->nama_siswa;

        //     // dd($id);

        //     function jadikanSatuArrayAktivasi($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan){

        //         return $array = [
        //             'idCicilan' => $idaktivasi, 
        //             'tanggal' => $tanggal, 
        //             'create' => $create, 
        //             'update' => $update, 
        //             'totalTerbayar' => "Rp" . number_format($totalTerbayar, 2, ",", "."),
        //             'sisaTagihan' => "Rp" . number_format($sisaTagihanPembayaranSementara, 2, ",", "."),
        //             'status' => 'lunas',
        //             'uangDibayarkan' => $uangDibayarkan
        //         ];
        //     }

        //     $rakSementara  = [];

        //     // id yang dibawah ini adalah id dari aktivasi_student
        //     // $idAktivasi = AktivasiStudent::find($id)->aktivasi_id;
        //     $totalPembayaran = Aktivasi::find($idAktivasi)->biaya;
            

        //     $totalTerbayar = 0;
        //     foreach( $cicilanAktivasi as $data ){

        //         $totalTerbayar = $totalTerbayar + $data->biaya;
        //         $uangDibayarkan = "Rp" . number_format($data->biaya, 2, ",", ".");
        //         $sisaTagihanPembayaranSementara = $totalPembayaran-$totalTerbayar;
        //         $idaktivasi = $data->id;
        //         $tanggal = date("d M Y", strtotime($data->tanggal));
        //         $create = $data->created_at;
        //         $update = $data->updated_at;

        //         $rak = jadikanSatuArrayAktivasi($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan);
        //         array_push($rakSementara, $rak);

        //     }

        //     $sisaPembayaran = $totalPembayaran-$totalTerbayar;
        //     $totalTerbayarDalamRupiah = "Rp" . number_format($totalTerbayar, 2, ",", ".");
        //     $sisaBayarDalamRupiah = "Rp" . number_format($sisaPembayaran, 2, ",", ".");

            
            





        // } elseif (stripos($namaProgram, 'Reguler') === 0) {

        //     $idStudent = KurikulumStudent::find($id)->student_id;
        //     $namaStudent = Student::find($idStudent)->nama_siswa;

        //     function jadikanSatuArrayReguler($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan){

        //         return $array = [
        //             'idCicilan' => $idaktivasi, 
        //             'tanggal' => $tanggal, 
        //             'create' => $create, 
        //             'update' => $update, 
        //             'status' => 'lunas',
        //             'totalTerbayar' => "Rp" . number_format($totalTerbayar, 2, ",", "."),
        //             'sisaTagihan' => "Rp" . number_format($sisaTagihanPembayaranSementara, 2, ",", "."),
        //             'uangDibayarkan' => $uangDibayarkan
        //         ];
        //     }

        //     $rakSementara  = [];

        //     $idKurikulum = KurikulumStudent::find($id)->kurikulum_id;
        //     $totalPembayaran = Kurikulum::find($idKurikulum)->biaya;

        //     $totalTerbayar = 0;
        //     foreach( $cicilanKurikulum as $data ){

        //         $totalTerbayar = $totalTerbayar + $data->biaya;
        //         $uangDibayarkan = "Rp" . number_format($data->biaya, 2, ",", ".");
        //         $sisaTagihanPembayaranSementara = $totalPembayaran-$totalTerbayar;
        //         $idaktivasi = $data->id;
        //         $tanggal = date("d M Y", strtotime($data->tanggal));
        //         $create = $data->created_at;
        //         $update = $data->updated_at;

        //         $rak = jadikanSatuArrayReguler($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan);
        //         array_push($rakSementara, $rak);

        //     }

        //     $sisaPembayaran = $totalPembayaran-$totalTerbayar;
        //     $totalTerbayarDalamRupiah = "Rp" . number_format($totalTerbayar, 2, ",", ".");
        //     $sisaBayarDalamRupiah = "Rp" . number_format($sisaPembayaran, 2, ",", ".");

            
        // }


        // if( count($rakSementara) === 0 ){
            
        //     $tanggal = 'Unknown';
        // }else{

        //     $dataTerakhir = count($rakSementara);
        //     $tanggal = $rakSementara[$dataTerakhir-1]['tanggal'];
        // }

        // // dd($totalTerbayarDalamRupiah);
        
        

        // return view('Pembayaran.index', [
        //     'title' => 'Cicilan - ',
        //     'active' => 'Pendaftaran',
        //     'nama_siswa' => $namaStudent,
        //     'nama_program' => $namaProgram,
        //     'id' => $id,
        //     'totalTerbayar' => $totalTerbayarDalamRupiah,
        //     'sisaPembayaran' => $sisaBayarDalamRupiah,
        //     'payments' => $rakSementara,
        //     'tanggal' => $tanggal,
        //     'count' => count($rakSementara)
        // ]);
    }

    public function createCost($id, $namaProgram){

        // dd($id);

        // if (stripos($namaProgram, 'Reguler') === false) {

        //     $idStudent = AktivasiStudent::find($id)->student_id;
        //     $namaStudent = Student::find($idStudent)->nama_siswa;

        // } elseif (stripos($namaProgram, 'Reguler') === 0) {

        //     $idStudent = KurikulumStudent::find($id)->student_id;
        //     $namaStudent = Student::find($idStudent)->nama_siswa;
            
        // }

        



        // return view('Pembayaran.create', [
        //     'title' => 'Cicilan - ',
        //     'active' => 'Pendaftaran',
        //     'nama_siswa' => $namaStudent,
        //     'nama_program' => $namaProgram,
        //     'id' => $id
        // ]);
    }

    public function storeCost(Request $request, $id, $namaProgram){

        // $id yang diterima adalah id aktivasi_student, atau id kurikulum_student
        // akan difilter dari sisi namaProgram nya apakah Reguler / Aktivasi, kemudian
        // ada 2 skenario algoritma
        // 1. Akan Ditolak jika belum pernah mencicil, namun cicilannya melebihi tagihan atau sudah pernah mencicil namun cicilannya melebihi tagihan
        // 2. Akan Diterima jika belum pernah mencicil dan cicilannya sesuai tagihan atau sudah pernah mencicil dan cicilannya sesuai sisa tagihan




        // $validatedData = $request->validate([
        //     'biaya' => 'required',
        //     'tanggal' => 'required',
        // ]);


        
        // if (stripos($namaProgram, 'Reguler') === false) {

            
        //     $aktivasiID = AktivasiStudent::find($id)->aktivasi_id;
        //     $biayaAktivasi = Aktivasi::find($aktivasiID)->biaya;
        //     $cicilan = CicilanAktivasiStudent::where('aktivasi_student', $id)->get();
            
        //     $sedangMencicil = count(CicilanAktivasiStudent::where('aktivasi_student', $id)->get()) > 0;
        //     if( $sedangMencicil){

        //         $cicil = 0;
        //         foreach( $cicilan as $item ){

        //             // dd($item);
        //             $cicil = $cicil+$item->total_pembayaran;

        //         }
                
                
        //         if( $validatedData['biaya'] > $cicil ){

        //             $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
        //             return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
        //         }

                
        //         $validatedData['aktivasi_student'] = $id;
        //         $validatedData['total_pembayaran'] = $cicil - $validatedData['biaya'];
        //         CicilanAktivasiStudent::create($validatedData);
                
        //         $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
        //         return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);
        //     }

            

        //     if( (int)$validatedData['biaya'] > $biayaAktivasi ){

        //         $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
        //         return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
        //     }

        //     $validatedData['aktivasi_student'] = $id;
        //     $validatedData['total_pembayaran'] = $biayaAktivasi - (int)$validatedData['biaya'];
        //     CicilanAktivasiStudent::create($validatedData);
            
        //     $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
        //     return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);

        // } elseif (stripos($namaProgram, 'Reguler') === 0) {

        //     $kurikulumID = KurikulumStudent::find($id)->kurikulum_id;
        //     $biayaKurikulum = Kurikulum::find($kurikulumID)->biaya;
        //     $cicilan = CicilanKurikulumStudent::where('kurikulum_student', $id)->get();
            
        //     $sedangMencicil = count(CicilanKurikulumStudent::where('kurikulum_student', $id)->get());
        //     if( $sedangMencicil){

        //         $cicil = 0;
        //         foreach( $cicilan as $item ){

        //             // dd($item);
        //             $cicil = $cicil+$item->total_pembayaran;

        //         }

                
                
        //         // dd((int)$validatedData['biaya']>$cicil);

        //         if( (int)$validatedData['biaya'] > $cicil ){

        //             // dd('atas');

        //             $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
        //             return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
        //         }

                
        //         $validatedData['kurikulum_student'] = $id;
        //         $validatedData['total_pembayaran'] = $cicil - (int)$validatedData['biaya'];
        //         CicilanKurikulumStudent::create($validatedData);
                
        //         $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
        //         return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);
        //     }

        //     // dd("luar");
            
        //     if( (int)$validatedData['biaya'] > $biayaKurikulum ){
                
        //         $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
        //         return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
        //     }

        //     $validatedData['kurikulum_student'] = $id;
        //     $validatedData['total_pembayaran'] = $biayaKurikulum - (int)$validatedData['biaya'];
        //     CicilanKurikulumStudent::create($validatedData);
            
        //     $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");

            
        //     return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);
        // }


    }
}
