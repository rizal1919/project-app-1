<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['remember_token'];

    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function scopeFilter($query, array $filters){
        
        $query->when($filters['nama'] ?? false, function($query, $nama){

            return $query->where('nama_siswa', 'like', '%' . $nama . '%');
            
        });

        $query->when($filters['nama_program'] ?? false, function($query, $nama_program){

            $id = Program::where('nama_program', 'like', '%' . $nama_program . '%')->get();

            // var_dump($id);

            $i=0;
            $arr = [];
            while( $i<count($id) ){
                
                $box = ['program_id', '=', $id[$i]->id];
                array_push($arr, $box);
                $i++;
            }

            // var_dump($query->where($arr)->get());

            // dd($arr);
            
            // return $query->where('nama_program', 'like', '%' . $nama_program . '%');
            return $query->where($arr)->get();
            
        });

        
        // $nama_program = $filters['nama_program'];

        

        $query->when($filters['ktp'] ?? false, function($query, $ktp){

            return $query->where('ktp', '=', $ktp);
        });
        $query->when($filters['ktp'] ?? false, function($query, $ktp){

            return $query->where('ktp', '=', $ktp);
        });

        
    }
}
