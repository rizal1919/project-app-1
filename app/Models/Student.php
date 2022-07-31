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

            $i=0;
            $arr = [];
            while( $i<count($id) ){
                
                $box = ['program_id', '=', $id[$i]->id];
                array_push($arr, $box);
                $i++;
            }
            // output [ ['program_id', '=', 3, ['program_id', '=', 2] ]

            
            return $query->where($arr)->get();
            // disini dilakukan query untuk mencari program sesuai dengan id yang didapat dari array
            
        });

        $query->when($filters['ktp'] ?? false, function($query, $ktp){

            return $query->where('ktp', '=', $ktp);
        });


        $query->when($filters['ktp'] ?? false, function($query, $ktp){

            return $query->where('ktp', '=', $ktp);
        });

        
    }
}
