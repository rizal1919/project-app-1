<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTeacher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function aktivasi(){
        return $this->belongsTo(Aktivasi::class);
    }

}
