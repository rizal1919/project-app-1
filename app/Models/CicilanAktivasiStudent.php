<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicilanAktivasiStudent extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function aktivasi(){
        return $this->belongsTo(Aktivasi::class);
    }
    public function aktivasiStudent(){
        return $this->belongsTo(AktivasiStudent::class);
    }
}
