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
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

use function GuzzleHttp\Promise\all;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {


        // $array = [

        //     [
        //         'student_id' => 1,
        //         'nama_siswa' => 'Rizal Fathurrahman',
        //         'nama_kurikulum' => 'Bisnis terpadu'
        //     ],

        //     [
        //         'student_id' => 1,
        //         'nama_siswa' => 'Rizal Fathurrahman',
        //         'nama_kurikulum' => 'Bisnis terpadu'
        //     ]

        // ];

        function jadikanSatuArrayReguler($idstudent, $nama_siswa, $nama_kurikulum, $idregularprogram, $updatedAt, $deletedAt)
        {

            if ($deletedAt === null) {

                $deletedAt = 'active';

                $array = [

                    'id' => $idregularprogram,
                    'student_id' => $idstudent,
                    'deleted_at' => $deletedAt,
                    'nama_siswa' => $nama_siswa,
                    'nama_program' => 'Reguler - ' . $nama_kurikulum,
                    'updated_at' => $updatedAt

                ];
            } else {

                $deletedAt = 'unactive';

                $array = [

                    'id' => $idregularprogram,
                    'student_id' => $idstudent,
                    'deleted_at' => $deletedAt,
                    'nama_siswa' => $nama_siswa,
                    'nama_program' => 'Reguler - ' . $nama_kurikulum,
                    'updated_at' => $updatedAt
                ];
            }


            return $array;
        }

        function jadikanSatuArrayAktivasi($idstudent, $nama_siswa, $nama_aktivasi, $idregularprogram, $updatedAt, $deletedAt)
        {
            if ($deletedAt === null) {

                $deletedAt = 'active';

                $array = [

                    'id' => $idregularprogram,
                    'student_id' => $idstudent,
                    'deleted_at' => $deletedAt,
                    'nama_siswa' => $nama_siswa,
                    'nama_program' => 'Aktivasi - ' . $nama_aktivasi,
                    'updated_at' => $updatedAt

                ];
            } else {

                $deletedAt = 'unactive';

                $array = [

                    'id' => $idregularprogram,
                    'student_id' => $idstudent,
                    'deleted_at' => $deletedAt,
                    'nama_siswa' => $nama_siswa,
                    'nama_program' => 'Aktivasi - ' . $nama_aktivasi,
                    'updated_at' => $updatedAt

                ];
            }

            return $array;
        }


        $dataKurikulum = Kurikulum::all();
        $dataAktivasi = Aktivasi::all();
        $dataStudent = Student::all();

        $dataRegulerStudent = DB::table('kurikulum_students')->get();
        $dataAktivasiStudent = DB::table('aktivasi_students')->get();

        function ambilNamaTerkait($dataProgramDiDaftarkan, $dataPilihanProgram, $dataStudent)
        {

            $rakDataStudentKurikulum = [];

            foreach ($dataProgramDiDaftarkan as $ReqStudent) {

                $idKurikulumDidapat = $ReqStudent->kurikulum_id;

                // dd($idKurikulumDidapat);
                $namaKurikulumDidapat = $dataPilihanProgram->find($idKurikulumDidapat)->nama_kurikulum;

                $idStudentDidapat = $ReqStudent->student_id;
                $namaStudentDidapat = $dataStudent->find($idStudentDidapat)->nama_siswa;

                $updateAtStudentDidapat = $ReqStudent->updated_at;
                $deletedAtStudentDidapat = $ReqStudent->deleted_at;

                $hasilArray = jadikanSatuArrayReguler($idStudentDidapat, $namaStudentDidapat, $namaKurikulumDidapat, $ReqStudent->id, $updateAtStudentDidapat, $deletedAtStudentDidapat);
                array_push($rakDataStudentKurikulum, $hasilArray);
            }

            return $rakDataStudentKurikulum;
        }

        function ambilNamaAktivasiTerkait($dataProgramDiDaftarkan, $dataPilihanProgram, $dataStudent)
        {

            $rakDataStudentAktivasi = [];

            foreach ($dataProgramDiDaftarkan as $ReqStudent) {

                $idAktivasiDidapat = $ReqStudent->aktivasi_id;
                $namaAktivasiDidapat = $dataPilihanProgram->find($idAktivasiDidapat)->nama_aktivasi;

                $idStudentDidapat = $ReqStudent->student_id;
                $namaStudentDidapat = $dataStudent->find($idStudentDidapat)->nama_siswa;

                $updateAtStudentDidapat = $ReqStudent->updated_at;
                $deletedAtStudentDidapat = $ReqStudent->deleted_at;

                $hasilArray = jadikanSatuArrayAktivasi($idStudentDidapat, $namaStudentDidapat, $namaAktivasiDidapat, $ReqStudent->id, $updateAtStudentDidapat, $deletedAtStudentDidapat);
                array_push($rakDataStudentAktivasi, $hasilArray);
            }

            return $rakDataStudentAktivasi;
        }


        $rakDataStudentKurikulum = ambilNamaTerkait($dataRegulerStudent, $dataKurikulum, $dataStudent);
        $rakDataStudentAktivasi = ambilNamaAktivasiTerkait($dataAktivasiStudent, $dataAktivasi, $dataStudent);
        
        $rakMergeData = array_merge($rakDataStudentKurikulum, $rakDataStudentAktivasi);
        $rakSemuaHasilData = collect($rakMergeData)->sortByDesc('updated_at')->sortBy('deleted_at');
        // sorting ini dilakukan untuk :
        // 1. mencari data paling baru diupdate terlebih dahulu
        // 2. mencari data yang statusnya masih aktif 

        $items = $request->nama_siswa;
        $kelas = $request->nama_program;
        $rakSemuaHasilData = collect($rakSemuaHasilData)->filter(function ($item) use ($items) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['nama_siswa'], $items);
        });
        $rakSemuaHasilData = collect($rakSemuaHasilData)->filter(function ($item) use ($kelas) {
            // replace stristr with your choice of matching function
            return false !== stristr($item['nama_program'], $kelas);
        });



        $rakSemuaHasilData = (new Collection($rakSemuaHasilData))->paginate(5);
        // dapet code di atas dari sini -> https://gist.github.com/simonhamp/549e8821946e2c40a617c85d2cf5af5e
        // kemudian bikin file Collection.php di models
        // ganti namespace nya jadi App\Models, kemudian panggil library nya use App\Models\Collection;
        // kemudian cara pakei nya seperti eloquent




        return view('Pendaftaran.index', [

            'title' => 'Pendaftaran',
            'active' => 'Pendaftaran',
            'dataSiswaReguler' => $rakSemuaHasilData

        ]);
    }

    public function indexReguler()
    {
        $date = date("Y-m-d");

        return view('Pendaftaran.create_reguler', [

            'active' => 'Pendaftaran',
            'title' => 'Tambah Reguler | ',
            'kurikulums' => Kurikulum::all(),
            'date' => $date,
            'students' => Student::all()
        ]);
    }

    public function indexAktivasi()
    {
        $date = date("Y-m-d");

        return view('Pendaftaran.create_aktivasi', [

            'active' => 'Pendaftaran',
            'title' => 'Tambah Reguler | ',
            'aktivasis' => Aktivasi::all(),
            'date' => $date,
            'students' => Student::all()
        ]);
    }

    public function storeReguler(Request $request)
    {

        $data = $request->collect();

        // dd($data);
       

        if( $request->collect("kurikulum_id")[0] === '0' ){
            return redirect('/form-registrasi/reguler')->with('pendaftaranGagal', $data['nama_siswa']);
        }
        

        $dataStudent = Student::where('ktp', '=', $data['ktp'])->get();

        // dd($dataStudent[0]->id);

        $dataPendaftar = [

            'student_id' => $dataStudent[0]->id,
            'kurikulum_id' => $data['kurikulum_id'],
        ];


        KurikulumStudent::create($dataPendaftar);
        


        return redirect('/form-registrasi')->with('pendaftaranBerhasil', $data['nama_siswa']);
    }

    public function storeAktivasi(Request $request)
    {

        $data = $request->collect();

        if( $request->collect("aktivasi_id")[0] === '0' ){
            return redirect('/form-registrasi/aktivasi')->with('pendaftaranGagal', $data['nama_siswa']);
        }

        // dd($data);

        $dataStudent = Student::where('ktp', '=', $data['ktp'])->get();

        // dd($dataStudent[0]->id);

        $dataPendaftar = [

            'student_id' => $dataStudent[0]->id,
            'aktivasi_id' => $data['aktivasi_id'],
        ];



        AktivasiStudent::create($dataPendaftar);

        return redirect('/form-registrasi')->with('pendaftaranBerhasil', $data['nama_siswa']);
    }



    public function softDeleteStudent($nama, $id, $namaSiswa)
    {

        // dd($namaSiswa);
        if (stripos($nama, 'Reguler') === false) {


            AktivasiStudent::find($id)->delete();
        } elseif (stripos($nama, 'Reguler') === 0) {


            KurikulumStudent::find($id)->delete();
        }


        return redirect('/form-registrasi')->with('destroy', $namaSiswa);
    }

    public function restoreStudent($nama, $id, $namaSiswa)
    {
        // dd($namaSiswa);
        if (stripos($nama, 'Reguler') === false) {

            AktivasiStudent::withTrashed()->find($id)->restore();
        } elseif (stripos($nama, 'Reguler') === 0) {

            KurikulumStudent::withTrashed()->find($id)->restore();
        }

        return redirect('/form-registrasi')->with('restore', $namaSiswa);
    }

    public function indexCost($id, $namaProgram){

        $dataAktivasi = Aktivasi::all();
        $dataKurikulum = Kurikulum::all();
        $cicilanAktivasi = DB::table('cicilan_aktivasi_students')->where('aktivasi_student', $id)->get();
        $cicilanKurikulum = DB::table('cicilan_kurikulum_students')->where('kurikulum_student', $id)->get();
        
        if (stripos($namaProgram, 'Reguler') === false) {

            $idStudent = AktivasiStudent::find($id)->student_id;
            $namaStudent = Student::find($idStudent)->nama_siswa;

            // dd($id);

            function jadikanSatuArrayAktivasi($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan){

                return $array = [
                    'idCicilan' => $idaktivasi, 
                    'tanggal' => $tanggal, 
                    'create' => $create, 
                    'update' => $update, 
                    'totalTerbayar' => "Rp" . number_format($totalTerbayar, 2, ",", "."),
                    'sisaTagihan' => "Rp" . number_format($sisaTagihanPembayaranSementara, 2, ",", "."),
                    'status' => 'lunas',
                    'uangDibayarkan' => $uangDibayarkan
                ];
            }

            $rakSementara  = [];

            // id yang dibawah ini adalah id dari aktivasi_student
            $idAktivasi = AktivasiStudent::find($id)->aktivasi_id;
            $totalPembayaran = Aktivasi::find($idAktivasi)->biaya;
            

            $totalTerbayar = 0;
            foreach( $cicilanAktivasi as $data ){

                $totalTerbayar = $totalTerbayar + $data->biaya;
                $uangDibayarkan = "Rp" . number_format($data->biaya, 2, ",", ".");
                $sisaTagihanPembayaranSementara = $totalPembayaran-$totalTerbayar;
                $idaktivasi = $data->id;
                $tanggal = date("d M Y", strtotime($data->tanggal));
                $create = $data->created_at;
                $update = $data->updated_at;

                $rak = jadikanSatuArrayAktivasi($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan);
                array_push($rakSementara, $rak);

            }

            $sisaPembayaran = $totalPembayaran-$totalTerbayar;
            $totalTerbayarDalamRupiah = "Rp" . number_format($totalTerbayar, 2, ",", ".");
            $sisaBayarDalamRupiah = "Rp" . number_format($sisaPembayaran, 2, ",", ".");

            
            





        } elseif (stripos($namaProgram, 'Reguler') === 0) {

            $idStudent = KurikulumStudent::find($id)->student_id;
            $namaStudent = Student::find($idStudent)->nama_siswa;

            function jadikanSatuArrayReguler($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan){

                return $array = [
                    'idCicilan' => $idaktivasi, 
                    'tanggal' => $tanggal, 
                    'create' => $create, 
                    'update' => $update, 
                    'status' => 'lunas',
                    'totalTerbayar' => "Rp" . number_format($totalTerbayar, 2, ",", "."),
                    'sisaTagihan' => "Rp" . number_format($sisaTagihanPembayaranSementara, 2, ",", "."),
                    'uangDibayarkan' => $uangDibayarkan
                ];
            }

            $rakSementara  = [];

            $idKurikulum = KurikulumStudent::find($id)->kurikulum_id;
            $totalPembayaran = Kurikulum::find($idKurikulum)->biaya;

            $totalTerbayar = 0;
            foreach( $cicilanKurikulum as $data ){

                $totalTerbayar = $totalTerbayar + $data->biaya;
                $uangDibayarkan = "Rp" . number_format($data->biaya, 2, ",", ".");
                $sisaTagihanPembayaranSementara = $totalPembayaran-$totalTerbayar;
                $idaktivasi = $data->id;
                $tanggal = date("d M Y", strtotime($data->tanggal));
                $create = $data->created_at;
                $update = $data->updated_at;

                $rak = jadikanSatuArrayReguler($idaktivasi, $tanggal, $create, $update, $totalTerbayar, $sisaTagihanPembayaranSementara, $uangDibayarkan);
                array_push($rakSementara, $rak);

            }

            $sisaPembayaran = $totalPembayaran-$totalTerbayar;
            $totalTerbayarDalamRupiah = "Rp" . number_format($totalTerbayar, 2, ",", ".");
            $sisaBayarDalamRupiah = "Rp" . number_format($sisaPembayaran, 2, ",", ".");

            
        }


        if( count($rakSementara) === 0 ){
            
            $tanggal = 'Unknown';
        }else{

            $dataTerakhir = count($rakSementara);
            $tanggal = $rakSementara[$dataTerakhir-1]['tanggal'];
        }

        // dd($totalTerbayarDalamRupiah);
        
        

        return view('Pembayaran.index', [
            'title' => 'Cicilan - ',
            'active' => 'Pendaftaran',
            'nama_siswa' => $namaStudent,
            'nama_program' => $namaProgram,
            'id' => $id,
            'totalTerbayar' => $totalTerbayarDalamRupiah,
            'sisaPembayaran' => $sisaBayarDalamRupiah,
            'payments' => $rakSementara,
            'tanggal' => $tanggal,
            'count' => count($rakSementara)
        ]);
    }

    public function createCost($id, $namaProgram){

        // dd($id);

        if (stripos($namaProgram, 'Reguler') === false) {

            $idStudent = AktivasiStudent::find($id)->student_id;
            $namaStudent = Student::find($idStudent)->nama_siswa;

        } elseif (stripos($namaProgram, 'Reguler') === 0) {

            $idStudent = KurikulumStudent::find($id)->student_id;
            $namaStudent = Student::find($idStudent)->nama_siswa;
            
        }

        



        return view('Pembayaran.create', [
            'title' => 'Cicilan - ',
            'active' => 'Pendaftaran',
            'nama_siswa' => $namaStudent,
            'nama_program' => $namaProgram,
            'id' => $id
        ]);
    }

    public function storeCost(Request $request, $id, $namaProgram){

        // $id yang diterima adalah id aktivasi_student, atau id kurikulum_student
        // akan difilter dari sisi namaProgram nya apakah Reguler / Aktivasi, kemudian
        // ada 2 skenario algoritma
        // 1. Akan Ditolak jika belum pernah mencicil, namun cicilannya melebihi tagihan atau sudah pernah mencicil namun cicilannya melebihi tagihan
        // 2. Akan Diterima jika belum pernah mencicil dan cicilannya sesuai tagihan atau sudah pernah mencicil dan cicilannya sesuai sisa tagihan




        $validatedData = $request->validate([
            'biaya' => 'required',
            'tanggal' => 'required',
        ]);


        
        if (stripos($namaProgram, 'Reguler') === false) {

            
            $aktivasiID = AktivasiStudent::find($id)->aktivasi_id;
            $biayaAktivasi = Aktivasi::find($aktivasiID)->biaya;
            $cicilan = CicilanAktivasiStudent::where('aktivasi_student', $id)->get();
            
            $sedangMencicil = count(CicilanAktivasiStudent::where('aktivasi_student', $id)->get()) > 0;
            if( $sedangMencicil){

                $cicil = 0;
                foreach( $cicilan as $item ){

                    // dd($item);
                    $cicil = $cicil+$item->total_pembayaran;

                }
                
                
                if( $validatedData['biaya'] > $cicil ){

                    $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
                    return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
                }

                
                $validatedData['aktivasi_student'] = $id;
                $validatedData['total_pembayaran'] = $cicil - $validatedData['biaya'];
                CicilanAktivasiStudent::create($validatedData);
                
                $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
                return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);
            }

            

            if( (int)$validatedData['biaya'] > $biayaAktivasi ){

                $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
                return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
            }

            $validatedData['aktivasi_student'] = $id;
            $validatedData['total_pembayaran'] = $biayaAktivasi - (int)$validatedData['biaya'];
            CicilanAktivasiStudent::create($validatedData);
            
            $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
            return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);

        } elseif (stripos($namaProgram, 'Reguler') === 0) {

            $kurikulumID = KurikulumStudent::find($id)->kurikulum_id;
            $biayaKurikulum = Kurikulum::find($kurikulumID)->biaya;
            $cicilan = CicilanKurikulumStudent::where('kurikulum_student', $id)->get();
            
            $sedangMencicil = count(CicilanKurikulumStudent::where('kurikulum_student', $id)->get());
            if( $sedangMencicil){

                $cicil = 0;
                foreach( $cicilan as $item ){

                    // dd($item);
                    $cicil = $cicil+$item->total_pembayaran;

                }

                
                
                // dd((int)$validatedData['biaya']>$cicil);

                if( (int)$validatedData['biaya'] > $cicil ){

                    // dd('atas');

                    $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
                    return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
                }

                
                $validatedData['kurikulum_student'] = $id;
                $validatedData['total_pembayaran'] = $cicil - (int)$validatedData['biaya'];
                CicilanKurikulumStudent::create($validatedData);
                
                $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
                return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);
            }

            // dd("luar");
            
            if( (int)$validatedData['biaya'] > $biayaKurikulum ){
                
                $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");
                return redirect('/cost/' . $id . '/' . $namaProgram)->with('gagalCicilan', $validatedData['biaya']);
            }

            $validatedData['kurikulum_student'] = $id;
            $validatedData['total_pembayaran'] = $biayaKurikulum - (int)$validatedData['biaya'];
            CicilanKurikulumStudent::create($validatedData);
            
            $validatedData['biaya'] = "Rp" . number_format($validatedData['biaya'], 2, ",", ".");

            
            return redirect('/cost/' . $id . '/' . $namaProgram)->with('tambahCicilan', $validatedData['biaya']);
        }


    }
}
