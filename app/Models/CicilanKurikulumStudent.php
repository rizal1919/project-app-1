<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicilanKurikulumStudent extends Model
{
    use HasFactory;

    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function kurikulum(){
        return $this->belongsTo(Kurikulum::class);
    }
    public function kurikulumStudent(){
        return $this->belongsTo(KurikulumStudent::class);
    }
}
