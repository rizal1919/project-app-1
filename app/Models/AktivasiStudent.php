<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktivasiStudent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    // public function program(){
    //     return $this->belongsTo(Program::class);
    // }
}
