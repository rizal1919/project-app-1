<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function assignteacher(){
        return $this->hasMany(AssignTeacher::class);
    }

    public function materi(){
        return $this->belongsToMany(Materi::class);
    }

    public function scopeFilter($query,  array $filters){

        $query->when($filters['teacher_name'] ?? false, function($query, $teacher_name){

            return $query->where(function($query) use($teacher_name){

                $query->where('teacher_name', 'like', '%' . $teacher_name . '%');
            });
        });
    }
}
