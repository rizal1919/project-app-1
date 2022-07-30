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

    public function scopeActive($query, $id){
        return $query->where('paket_pilihan','=',$id);
    }

    public function scopeFilter($query, array $filters){
        
        $query->when($filters['nama'] ?? false, function($query, $nama){

            return $query->where('nama_siswa', 'like', '%' . $nama . '%');
            
        });

        $query->when($filters['ktp'] ?? false, function($query, $ktp){

            return $query->where('ktp', '=', $ktp);
        });
        $query->when($filters['ktp'] ?? false, function($query, $ktp){

            return $query->where('ktp', '=', $ktp);
        });

        
    }
}
