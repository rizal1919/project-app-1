<?php

namespace App\Http\Controllers;

use App\Models\Aktivasi;
use App\Models\Installment;
use App\Models\Kurikulum;
use App\Models\Program;
use App\Models\PIC;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{

    // public function ajax(){

    //     return view('DataSiswa.ajax');
    // }

    public function getSiswa(){
        $d = array();
        $data = Student::get(['nama_siswa AS text', 'id']);
        $d["results"] = $data;
        return $d;
    }

    // public function autocomplete(Request $request)
    // {

    //     if($request->ajax()){

            
    //         $data =  Student::where('nama_siswa', 'like', '%'. $request->nama_siswa . '%')->get();
    //         $output = '';
    //         if( $request->nama_siswa == '' ){

    //             $output = '';
    //         }elseif(count($data) > 0 ){

    //             $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
    //             foreach( $data as $row ){
    //                 $output .= '<li class="list-group-item" id="n">' . $row->nama_siswa . '</li>';
    //             }

    //             $output .= '</ul>';
    //         }else{

    //             $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
    //             $output .= '<li class="list-group-item" id="n"> Data Tidak Ditemukan </li>';
    //             $output .= '</ul>';
    //         }
    //         return $output;
            
            
    //     }

    //     return view('DataSiswa.ajax');
    // }
    
    public function search(Request $request)
    {

        
            $data =  Student::where('nama_siswa', '=', $request->name)->get();

            // if( $request->name == '' ){
            //     $data = [''];
                
            // }

            // if(count($data) == 0){
            //     $data = [''];
            // }

            return $data;
            
        

        
    }

    // public function alamatEmail(Request $request)
    // {

    //     if($request->ajax()){

            
    //         $data =  Student::where('email', 'like', '%'. $request->email . '%')->get();
    //         $output = '';
    //         if( $request->email == '' ){

    //             $output = '';
    //         }elseif(count($data) > 0 ){

    //             $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
    //             foreach( $data as $row ){
    //                 $output .= '<li class="list-group-item" id="e">' . $row->email . '</li>';
    //             }

    //             $output .= '</ul>';
    //         }else{

    //             $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
    //             $output .= '<li class="list-group-item" id="e"> Data Tidak Ditemukan </li>';
    //             $output .= '</ul>';
    //         }
    //         return $output;
            
            
    //     }

    //     return view('DataSiswa.ajax');
    // }

    // public function autocomplete(Request $request)
    // {
    //     $data = Student::select("nama_siswa")
    //             ->where("nama_siswa","LIKE","%{$request->term}%")
    //             ->get();

    //     // $data = Student::where('nama_siswa', 'LIKE', '%' . $request->input('query') . '%')->get();
    //     // dd($data);
    //     return response()->json($data);
    // }

    public function index(){


        $dataSiswa = Student::filter(request(['nama','ktp','nama_kurikulum','tahun']))->orderBy('id', 'desc')->paginate(5)->withQueryString();
       
        return view('DataSiswa.index',[

            'title' => 'Data Siswa | ',
            'active' => 'Data Siswa',
            'dataSiswa' => $dataSiswa
        ]);
    }

    public function studentDashboard(Student $student){

        // dd($student->aktivasi);

        $pictures = ['black-white', 'building', 'doors', 'table', 'tower', 'water-box'];
       
        $rakStudent = [];
        $rakCicilan = [];
        $status = '';
        if( $student->aktivasi->count() > 0 ){
            
            foreach( $student->aktivasi as $aktivasi ){

                $cekStatusKelulusan = DB::table('aktivasi_student')->where(['aktivasi_id' => $aktivasi->id], ['student_id' => $student->id ])->get();

                $cekStatusKelulusan[0]->deleted_at != null ? $status = 'Lulus' : $status = 'Sedang Berjalan';

                $totalMateri = 0;
                foreach( $aktivasi->program as $program ){

                    $totalMateri = $totalMateri + $program->materi->count();
                }

                
               
                $rak = [
                    'namaAktivasi' => $aktivasi->nama_aktivasi,
                    'status' => $status,
                    'picture' => $pictures[rand(0,6)],
                    'programs' => $aktivasi->program->count(),
                    'materis' => $totalMateri
                ];

                array_push($rakStudent, $rak);

               
 
            }
        }

       
        return view('DataSiswa.studentDashboard', [
            'active' => 'Data Siswa',
            'student' => $student,
            'aktivasis' => $rakStudent
        ]);
    }

    public function export(Student $student){

        $ayah = $student->tanggal_lahir_ayah;
        $ayah = explode('-', $ayah)[0];
        $ibu = $student->tanggal_lahir_ibu;
        $ibu = explode('-', $ibu)[0];


        return view('DataSiswa.pdf', [
            'title' => 'Export',
            'active' => 'Data Siswa',
            'student' => $student,
            'tahun_lahir_ayah' => $ayah,
            'tahun_lahir_ibu' => $ibu,
            'penghasilan_ayah' => "Rp" . number_format($student->penghasilan_ayah, 2, ",", "."),
            'penghasilan_ibu' => "Rp" . number_format($student->penghasilan_ibu, 2, ",", "."),
            'aktivasis' => Aktivasi::all()
        ]);
    }

    public function create(){

        $nomorUrut = Student::all()->last();

        

        $year = date("Y")[3] . date("Y")[2];
        // mengambil 2 angka akhir pada tahun

        $normalYear = date('Y');
        $date = date("Y-m-d");
        
        if($nomorUrut === null){
            $hasilAkhirNoUrut = '00001' . $year;
            // dd($hasilAkhirNoUrut);
        }else{
            
            // $str = (string)$nomorUrut;
            // $tes = $str[4];
            $nomorUrut = $nomorUrut->nomor_pendaftaran;

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

        
        return view('DataSiswa.create', [

            'title' => 'Daftar Siswa',
            'active' => 'Data Siswa',
            'nomor' => $hasilAkhirNoUrut,
            'year' => $normalYear,
            'date' => $date,
            'pics' => PIC::all()
        ]);
    }

    public function store(Request $request){

        // dd($request->collect());
        
        $validatedData = $request->validate([
            
            'picture' => 'image|file|max:1024',
            'nama_siswa' => 'required',
            'nama_panggilan_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'ktp' => 'required|min:16|max:16|unique:students',
            'email' => 'required|email|unique:students',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'nama_jalan_ktp' => 'required',
            'rt_ktp' => 'required',
            'rw_ktp' => 'required',
            'nama_desa_ktp' => 'required',
            'nama_kecamatan_ktp' => 'required',
            'nama_jalan_domisili' => 'required',
            'rt_domisili' => 'required',
            'rw_domisili' => 'required',
            'nama_desa_domisili' => 'required',
            'nama_kecamatan_domisili' => 'required',
            'tempat_tinggal' => 'required',
            'transportasi' => 'required',
            'no_hp' => 'required|unique:students',
            'asal_sekolah' => 'required',
            'kota_asal_sekolah' => 'required',
            'pic_id' => 'nullable',
            'nomor_pendaftaran' => 'required',
            'tahun_daftar' => 'required',
            'password' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'tanggal_lahir_ayah' => 'required',
            'tanggal_lahir_ibu' => 'required',
            'pendidikan_ayah' => 'required',
            'pendidikan_ibu' => 'required',
            'pekerjaan_ayah' => 'required',
            'pekerjaan_ibu' => 'required',
            'penghasilan_ayah' => 'required',
            'penghasilan_ibu' => 'required',
            'keterangan_ayah' => 'required',
            'keterangan_ibu' => 'required',
            'nama_jalan_ortu' => 'required',
            'rt_ortu' => 'required',
            'rw_ortu' => 'required',
            'nama_desa_ortu' => 'required',
            'nama_kecamatan_ortu' => 'required',
            'tinggi_badan' => 'required',
            'jarak_tempuh_sekolah' => 'required',
            'urutan_anak' => 'required',
            'jumlah_saudara' => 'required'
            
        ],[
            'picture.max' => 'Ukuran file terlalu besar'
        ]);
        

        if($request->file('picture')){
            $validatedData['picture'] = $request->file('picture')->store('img-siswa');
        }
        
        Student::create($validatedData);

        return redirect('/data-siswa')->with('pendaftaranBerhasil', 'Registrasi Berhasil - ' . $validatedData['nomor_pendaftaran'] . ' ');

    }

    public function show(Student $student){

        $student = Student::find($student->id);

        // mengubah format tanggal menjadi dd-mm-yyyy
        $str = $student->tanggal_lahir;
        $str2 = explode("-",$str);
        $rightYear = $str2[2] . '-' . $str2[1] . '-' . $str2[0];
        $student->tanggal_lahir = $rightYear;

        return view('DataSiswa.show',[
            'title' => $student->nama_siswa . ' |',
            'active' => 'Data Siswa',
            'student' => $student
        ]);
    }

    public function edit(Student $student){

        $student = Student::find($student->id);


        return view('DataSiswa.update',[
            'title' => $student->nama_siswa . ' |',
            'active' => 'Data Siswa',
            'student' => $student,
            'year' => date('Y'),
            'date' => date("Y-m-d"),
            'pics' => PIC::all()
        ]);
    }

    public function update(Request $request, Student $student){

        // dd($request->collect());

        $rules = [
            'nama_siswa' => 'required',
            'nama_panggilan_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'ktp' => ['required','min:16','max:16',Rule::unique('students')->ignore($student->id)],
            'email' => ['required','email',Rule::unique('students')->ignore($student->id)],
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'nama_jalan_ktp' => 'required',
            'rt_ktp' => 'required',
            'rw_ktp' => 'required',
            'nama_desa_ktp' => 'required',
            'nama_kecamatan_ktp' => 'required',
            'nama_jalan_domisili' => 'required',
            'rt_domisili' => 'required',
            'rw_domisili' => 'required',
            'nama_desa_domisili' => 'required',
            'nama_kecamatan_domisili' => 'required',
            'tempat_tinggal' => 'required',
            'transportasi' => 'required',
            'no_hp' => ['required',Rule::unique('students')->ignore($student->id)],
            'asal_sekolah' => 'required',
            'kota_asal_sekolah' => 'required',
            'pic_id' => 'required',
            'nomor_pendaftaran' => 'required',
            'tahun_daftar' => 'required',
            'password' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'tanggal_lahir_ayah' => 'required',
            'tanggal_lahir_ibu' => 'required',
            'pendidikan_ayah' => 'required',
            'pendidikan_ibu' => 'required',
            'pekerjaan_ayah' => 'required',
            'pekerjaan_ibu' => 'required',
            'penghasilan_ayah' => 'required',
            'penghasilan_ibu' => 'required',
            'keterangan_ayah' => 'required',
            'keterangan_ibu' => 'required',
            'nama_jalan_ortu' => 'required',
            'rt_ortu' => 'required',
            'rw_ortu' => 'required',
            'nama_desa_ortu' => 'required',
            'nama_kecamatan_ortu' => 'required',
            'tinggi_badan' => 'required',
            'jarak_tempuh_sekolah' => 'required',
            'urutan_anak' => 'required',
            'jumlah_saudara' => 'required',
            
        ];

        $validatedData = $request->validate($rules);


        if($request->file('picture')){

            if($request->oldPicture){
                Storage::delete($student->picture);
            }
            $validatedData['picture'] = $request->file('picture')->store('img-siswa');
        }

        // dd($validatedData);
        
        Student::where('id', $student->id)->update($validatedData);

        return redirect('/data-siswa/update/student/' . $student->id)->with('updateBerhasil', $validatedData['nama_siswa']);
    }

    public function destroy(Student $student){

        // $dataSiswaAktivasi = DB::table('aktivasi_students')->where('student_id', $student->id)->get();
        // dd($dataSiswaAktivasi);

        // if( count($dataSiswaAktivasi) > 0 ){
        //     return redirect('/data-siswa')->with('destroyFailed', 'Program Reguler dan Aktivasi');
        // }elseif( count($dataSiswaAktivasi) === 0 ){
        //     return redirect('/data-siswa')->with('destroyFailed', 'Program Reguler');
        // }elseif( count($dataSiswaAktivasi) > 0 ){
        //     return redirect('/data-siswa')->with('destroyFailed', 'Program Aktivasi');
        // }

        if( $student->picture ){
            Storage::delete($student->picture);
        }


        $student->delete();

        return redirect('/data-siswa')->with('destroy', $student->nama_siswa);

    }
}
