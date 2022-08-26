<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    
    public function program(){
        return $this->hasMany(Program::class);
    }

    public function student(){
        return $this->hasMany(Student::class);
    }
    
    public function cicilanKurikulumStudent(){
        return $this->hasMany(CicilanKurikulumStudent::class);
    }

    public function scopeFilter($query, array $filters){

        $query->when($filters['search'] ?? false, function( $query, $search ){

            return $query->where('nama_kurikulum', 'like', '%' . $search . '%');
        });
    }

}
