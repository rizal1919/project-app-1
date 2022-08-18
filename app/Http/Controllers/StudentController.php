<?php

namespace App\Http\Controllers;
use App\Models\Kurikulum;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    // public function ajax(){

    //     return view('DataSiswa.ajax');
    // }

    public function autocomplete(Request $request)
    {

        if($request->ajax()){

            
            $data =  Student::where('nama_siswa', 'like', '%'. $request->nama_siswa . '%')->get();
            $output = '';
            if( $request->nama_siswa == '' ){

                $output = '';
            }elseif(count($data) > 0 ){

                $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
                foreach( $data as $row ){
                    $output .= '<li class="list-group-item" id="n">' . $row->nama_siswa . '</li>';
                }

                $output .= '</ul>';
            }else{

                $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
                $output .= '<li class="list-group-item" id="n"> Data Tidak Ditemukan </li>';
                $output .= '</ul>';
            }
            return $output;
            
            
        }

        return view('DataSiswa.ajax');
    }
    
    public function ktp(Request $request)
    {

        if($request->ajax()){

            
            $data =  Student::where('ktp', '=', $request->ktp)->get();

            if( $request->ktp == '' ){
                $data = [''];
                
            }

            if(count($data) == 0){
                $data = [''];
            }
            return $data;
            
            
        }

        return view('DataSiswa.ajax');
    }

    public function alamatEmail(Request $request)
    {

        if($request->ajax()){

            
            $data =  Student::where('email', 'like', '%'. $request->email . '%')->get();
            $output = '';
            if( $request->email == '' ){

                $output = '';
            }elseif(count($data) > 0 ){

                $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
                foreach( $data as $row ){
                    $output .= '<li class="list-group-item" id="e">' . $row->email . '</li>';
                }

                $output .= '</ul>';
            }else{

                $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
                $output .= '<li class="list-group-item" id="e"> Data Tidak Ditemukan </li>';
                $output .= '</ul>';
            }
            return $output;
            
            
        }

        return view('DataSiswa.ajax');
    }

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
        $students = Student::all();
        // dd($tes->kurikulum->nama_kurikulum);
           
        
        return view('DataSiswa.index',[

            'title' => 'Data Siswa | ',
            'active' => 'Data Siswa',
            'dataSiswa' => $dataSiswa,
            'students' => $students
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
        ]);
    }

    public function store(Request $request){

        // dd($request->collect());
        
        $validatedData = $request->validate([
            
            'nama_siswa' => 'required',
            'ktp' => 'required|min:16|max:16|unique:students',
            'email' => 'required|email:dns|unique:students',
            'tanggal_lahir' => 'required',
            'nomor_pendaftaran' => 'required',
            'tahun_daftar' => 'required',
            'password' => 'required',
            'status' => 'required'
            
            
        ],[
            'nama_siswa.required' => 'Nama harus diisi',
            'ktp.required' => 'KTP tidak boleh kosong',
            'ktp.unique' => 'KTP telah digunakan',
            'ktp.min' => 'KTP terdiri dari minimal 16 angka',
            'ktp.max' => 'KTP terdiri dari maksimal 16 angka',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email telah terdaftar',
            'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
        ]);
        
        $validatedData = $request->collect();
        $validatedData = current( (Array) $validatedData );
        // kenapa dipanggil dengan collection? karna data yang tidak diinputkan user itu selalu gagal divalidasi.
        // disini makanya diinputkan collection, kemudian dari obj dijadikan array. kemudian di create
        
        // if($validatedData['kurikulum_id'] == 0){
            
        //     return redirect('/form-registrasi-1')->with('pendaftaranGagal', 'Pendaftaran Gagal!!');
        // }
        
        // dd($validatedData);
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
            'kurikulums' => Kurikulum::all()
        ]);
    }

    public function update(Request $request, Student $student){



        $validatedData = $request->validate([

            'nama_siswa' => 'required',
            'kurikulum_id' => 'required',
            'ktp' => 'required|min:16|max:16|unique:students,ktp,'.$student->id,
            'tanggal_lahir' => 'required',
            'email' => 'required|email:dns|unique:students,email,'.$student->id,
            'password' => 'required',
            'nomor_pendaftaran' => 'required',
            'tahun_daftar' => 'required'

        ]);

        $id = $student->id;

        if($validatedData['kurikulum_id'] == 0){

            return redirect('/data-siswa/update/student/' . $id)->with('updateGagal', 'Update Gagal!!');
        }

        $student->update([
            'nama_siswa' => $validatedData['nama_siswa'],
            'kurikulum_id' => $validatedData['kurikulum_id'],
            'ktp' => $validatedData['ktp'],
            'email' => $validatedData['email'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'password' => $validatedData['password'],
            'nomor_pendaftaran' => $validatedData['nomor_pendaftaran'],
            'tahun_daftar' => $validatedData['tahun_daftar'],
        ]);



        return redirect('/data-siswa/update/student/' . $id)->with('updateBerhasil', 'Berhasil Ubah Data!! ');
    }

    public function destroy(Student $student){

        $student->find($student->id)->delete();

        return redirect('/data-siswa')->with('destroy', 'Delete Successfully!');

    }
}
