<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function kurikulum(){
        return $this->belongsTo(Kurikulum::class);
    }

    public function assignteacher(){
        return $this->hasMany(AssignTeacher::class);
    }

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){

            return $query->where(function($query) use ($search){

                $query->where('nama_materi', 'like', '%' . $search . '%');
            });
            
        });

    }

    public function scopeActive($query, $id){
        return $query->where('program_id','=',$id);
    }
}
