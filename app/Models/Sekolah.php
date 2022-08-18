<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters){
        
        $query->when($filters['nama_sekolah'] ?? false, function($query, $search){

            return $query->where(function($query) use ($search){

                $query->where('nama_sekolah', 'like', '%' . $search . '%');
            });
            
        });

        

    }
}
