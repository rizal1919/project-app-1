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
        $rakSementara = [];
        if($dataAktivasi->count() > 0){

            foreach( $dataAktivasi as $aktivasi ){

                if( $aktivasi->student->count() > 0 ){

                    foreach( $aktivasi->student as $student ){

                        $installments = Installment::where(['aktivasi_id' => $aktivasi->id, 'student_id' => $student->id])->get();

                        $status = '';
                        foreach( $installments as $installment ){

                            // dd($installment);

                            if( $installment->status == 'Belum Bayar' ){

                                $status = 'Belum Bayar';
                                break;
                            }else{
                                $status = 'Paid';
                            }
                        }

                        $deletedAt = DB::table('aktivasi_student')->select('deleted_at')->where([
                            'aktivasi_id' => $aktivasi->id,
                            'student_id' => $student->id
                        ])->get();

                        if( $deletedAt[0]->deleted_at === null ){
                            $studentStatus = 'On Going';
                        }else{
                            $studentStatus = 'Graduated';
                        }

                        $rak = [
                            'idStudent' => $student->id,
                            'idActivation' => $aktivasi->id,
                            'studentName' => $student->nama_siswa,
                            'activationName' => $aktivasi->nama_aktivasi,
                            'studentStatus' => $studentStatus,
                            'payment' => $status,
                            'updated_at' => $aktivasi->updated_at
                        ];

                        array_push($rakSementara, $rak);
                    }
                }

            }

            
        }

        // dd($rakSementara);
        
        $studentName = $request->studentName;
        $rakSementara = collect($rakSementara)->filter(function ($item) use ($studentName) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['studentName'], $studentName);
        });

        $activationName = $request->activationName;
        $rakSementara = collect($rakSementara)->filter(function ($item) use ($activationName) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['activationName'], $activationName);
        });

        if( $request->search == 'On Going' ){
            $search = $request->search;
            $rakSementara = collect($rakSementara)->filter(function ($item) use ($search) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['studentStatus'], $search);
            });
        }
        if( $request->search == 'Graduated' ){
            $search = $request->search;
            $rakSementara = collect($rakSementara)->filter(function ($item) use ($search) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['studentStatus'], $search);
            });
        }
        if( $request->search == 'Belum Bayar' ){
            $search = $request->search;
            $rakSementara = collect($rakSementara)->filter(function ($item) use ($search) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['payment'], $search);
            });
        }
        if( $request->search == 'Paid' ){
            $search = $request->search;
            $rakSementara = collect($rakSementara)->filter(function ($item) use ($search) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['payment'], $search);
            });
        }

        $rakSementara = collect($rakSementara)->sortByDesc('studentStatus');
        
        // dd($rakSementara);


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
                    'status' => 'Belum Bayar'
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
                        'status' => 'Belum Bayar'
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
                        'status' => 'Belum Bayar'
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
                        'status' => 'Belum Bayar'
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
                        'status' => 'Belum Bayar'
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


        
        // table 'daftar_nilai'
        $programs = Aktivasi::find((int)$request->aktivasi_id)->program;

        foreach( $programs as $program ){
            
            foreach( $program->materi as $materi ){

                DB::table('daftar_nilai')->insert([
                    'student_id' => $validatedData['student_id'],
                    'aktivasi_id' => $validatedData['aktivasi_id'],
                    'materi_id' => $materi->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                
            }
        }
        
        // table 'installments'
        for( $i=1; $i<=$validatedData['metode_pembayaran']; $i++ ){
            
            $schedule = date('Y-m-d', mktime($hour, $minutes, $seconds, $month+$i, $day, $year));

            Installment::create([
                'aktivasi_id' => $validatedData['aktivasi_id'],
                'student_id' => $validatedData['student_id'],
                'installment' => $biayaAkhir,
                'paid' => 0,
                'status' => 'Belum Bayar',
                'date_payment' => $schedule
            ]);
        }

        // table 'aktivasi_student'
        DB::table('aktivasi_student')->insert([
            'aktivasi_id' => $validatedData['aktivasi_id'],
            'student_id' => $validatedData['student_id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);



        $nama_siswa = Student::find($validatedData['student_id'])->nama_siswa;
        return redirect('/form-registrasi')->with('pendaftaranBerhasil', $nama_siswa);
    }



    public function softDeleteStudent($student_id, $activation_id)
    {

        $namaSiswa = Student::find($student_id)->nama_siswa;
    
        DB::table('aktivasi_student')->where([
                'aktivasi_id' => $activation_id,
                'student_id' => $student_id        
        ])->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


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

    public function indexCost(Student $student, $id){

       
        $dataCicilan = Installment::where([
            'aktivasi_id' => $id,
            'student_id' => $student->id
        ])->get();
        

        // dd($dataCicilan);
        $dataAktivasi = Aktivasi::find($dataCicilan[0]->aktivasi_id);
        $biayaTerbayar = $dataCicilan->sum('paid');
        $biayaSisaTagihan = $dataAktivasi->biaya - $biayaTerbayar;

        // ini untuk ditampilkan di bagian informasi
        $cariPembayaranTerakhir = Installment::where([
            'aktivasi_id' => $id,
            'student_id' => $student->id
        ])->orderBy('updated_at', 'desc')->first();
        $tanggalPembayaranTerakhir = date('d M Y', strtotime($cariPembayaranTerakhir->date_payment));


        
        // query data cicilan
        $rakCicilan = [];
        $count = 1;
        foreach( $dataCicilan as $cicilan ){

            $hasilExplode = explode('-', $cicilan->date_payment);
            $hasilExplode = $hasilExplode[2] . '-' . $hasilExplode[1] . '-' . $hasilExplode[0];
            
            $dataCicilan->count() === 1 ? $namaCicilan = 'Tunai' : $namaCicilan = 'Cicilan' . $count;

            $rak = [
                'idCicilan' => $cicilan->id,
                'Nama Cicilan' => $namaCicilan,
                'Tanggal' => $hasilExplode,
                'Tagihan' => "Rp" . number_format($cicilan->installment, 2, ",", "."),
                'Terbayar' => "Rp" . number_format($cicilan->paid, 2, ",", "."),
                'Status' => $cicilan->status
            ];

            array_push($rakCicilan, $rak);

            $count++;
        }



        
        // dd($rakCicilan);
        
        

        return view('Pembayaran.index', [
            'title' => 'Cicilan - ',
            'active' => 'Pendaftaran',
            'dataCicilan' => $rakCicilan,
            'biayaAktivasi' => "Rp" . number_format($dataAktivasi->biaya, 2, ",", "."),
            'namaAktivasi' => $dataAktivasi->nama_aktivasi,
            'biayaTerbayar' =>  "Rp" . number_format($biayaTerbayar, 2, ",", "."),
            'biayaSisaTagihan' =>  "Rp" . number_format($biayaSisaTagihan, 2, ",", "."),
            'siswa' => $student,
            'dataAktivasi' => $dataAktivasi,
            'terakhirPembayaran' => $tanggalPembayaranTerakhir
            
        ]);
    }

    

    public function storeCost(Request $request, $id){

       
       $cicilan = Installment::find($id);
        
       
       $tanggal = $cicilan->date_payment;

       if( $request->tanggal != null ){
            $tanggal = $request->tanggal;
       }

       Installment::where('id', $id)->update([
            'paid' => $cicilan->paid + (int)$cicilan->installment,
            'status' => 'Paid',
            'date_payment' => $tanggal
       ]);

       return redirect('/cost/' . $cicilan->student_id . '/' . $cicilan->aktivasi_id)->with('PaymentSuccess', 'Berhasil');


    }

    public function updateDate(Request $request, $id){

        
        $dataCicilan = Installment::where('id', $id)->first();
        // dd($dataCicilan->student_id);
        $dataCicilan->update(['date_payment' => $request->tanggal]);

        return redirect('/cost/' . $dataCicilan->student_id . '/' . $dataCicilan->aktivasi_id)->with('UpdateSuccess', 'Berhasil!');
    }
}
