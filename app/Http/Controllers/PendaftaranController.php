<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\AktivasiStudent;
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
            'date' => $date
        ]);
    }

    public function indexAktivasi()
    {
        $date = date("Y-m-d");

        return view('Pendaftaran.create_aktivasi', [

            'active' => 'Pendaftaran',
            'title' => 'Tambah Reguler | ',
            'aktivasis' => Aktivasi::all(),
            'date' => $date
        ]);
    }

    public function storeReguler(Request $request)
    {

        $data = $request->collect();

        // dd($data['ktp']);

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

        // dd($data['ktp']);

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
}
