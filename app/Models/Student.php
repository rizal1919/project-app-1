<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['remember_token'];

    public function kurikulum(){
        return $this->belongsTo(Kurikulum::class);
    }

    public function cicilanAktivasiStudent(){
        return $this->hasMany(CicilanAktivasiStudent::class);
    }
    public function cicilanKurikulumStudent(){
        return $this->hasMany(CicilanKurikulumStudent::class);
    }

    public function scopeFilter($query, array $filters){
        
        $query->when($filters['nama'] ?? false, function($query, $nama){

            return $query->where('nama_siswa', 'like', '%' . $nama . '%');
            
        });

        $query->when($filters['nama_kurikulum'] ?? false, function($query, $nama_kurikulum){

            $id = Kurikulum::where('nama_kurikulum', 'like', '%' . $nama_kurikulum . '%')->get();

            // dd($id);
            $arr = [];
            if( count($id) == 0){
                array_push($arr, ['kurikulum_id', '=', 0]);
            }else{

                $i=0;
                while( $i<count($id) ){
                    
                    $box = ['kurikulum_id', '=', $id[$i]->id];
                    array_push($arr, $box);
                    $i++;
                }
            }

            // output [ ['program_id', '=', 3, ['program_id', '=', 2] ]

            // dd($arr);
            return $query->where($arr)->get();
            // disini dilakukan query untuk mencari program sesuai dengan id yang didapat dari array
            
        });

        $query->when($filters['tahun'] ?? false, function($query, $tahun){

            return $query->where('tahun_daftar', '=', $tahun);
        });


        $query->when($filters['ktp'] ?? false, function($query, $ktp){

            return $query->where('ktp', '=', $ktp);
        });

        
    }
}
