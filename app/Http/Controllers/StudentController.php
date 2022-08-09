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

            
            $data =  Student::where('ktp', 'like', '%'. $request->ktp . '%')->get();

            
            $output = '';
            if( $request->ktp == '' ){
                $data = [''];
                $output = '';
            }elseif(count($data) > 0 ){

                $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
                foreach( $data as $row ){
                    $output .= '<li class="list-group-item" id="k">' . $row->ktp . '</li>';
                }

                $output .= '</ul>';
            }else{

                $output = '<ul class="list-group" style="display:block; position:relative; z-index:1">';
                $output .= '<li class="list-group-item" id="k"> Data Tidak Ditemukan </li>';
                $output .= '</ul>';
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
