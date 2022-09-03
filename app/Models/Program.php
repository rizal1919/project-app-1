<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function materi(){
        return $this->hasMany(Materi::class);
    }

    public function aktivasi(){
        return $this->hasMany(Aktivasi::class);
    }
    
    public function scopeFilter($query, array $filters){
        
        $query->when($filters['search'] ?? false, function($query, $search){

            return $query->where(function($query) use ($search){

                $query->where('nama_program', 'like', '%' . $search . '%');
            });
            
        });

        // $query->when($filters['nama_program'] ?? false, function($query, $nama_program){

        //     return $query->where('nama_program', 'like', '%' . $nama_program . '%');
            
        // });

    }
    
    public function scopeActive($query, $id){
        return $query->where('program_id','=',$id);
    }

    public function scopeMencariSiswa($query, $id){
        return $query->where('paket_pilihan','=',$id);
    }
}   
