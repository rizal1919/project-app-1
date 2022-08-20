<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters){
        $query->when($filters['classroom_name'] ?? false, function($query, $classroom_name){

            return $query->where(function($query) use($classroom_name){

                $query->where('classroom_name', 'like', "%{$classroom_name}%");
            });
        });
    }
}
