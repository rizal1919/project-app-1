<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters){

        $query->when($filters['search'] ?? false, function( $query, $search ) {

            return $query->where('nama_aktivasi', 'like', "%{$search}%")->get();
        });
    }
}