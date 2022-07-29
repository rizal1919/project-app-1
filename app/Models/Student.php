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
}
