<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PIC extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
    }

    public function scopeFilter($query, array $filters){
        
        $query->when($filters['nama_pic'] ?? false, function($query, $search){

            return $query->where(function($query) use ($search){

                $query->where('nama_pic', 'like', '%' . $search . '%');
            });
            
        });

        

    }
}
