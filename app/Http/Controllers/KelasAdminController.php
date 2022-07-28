<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class KelasAdminController extends Controller
{
    public function index(Request $request){

        $search = $request->search;
        $programs = Program::when($search, function($query, $search){
            return $query->where('nama_program','like',"%$search%");
        })->paginate(6);

        $category = ['college','engineer','car','man','programmer','developer','asian'];
        
        
        return view('Kelas.index',[

            'title' => 'Kelas',
            'active' => 'Kelas',
            'category' => $category,
            'programs' => $programs
        ]);
    }

    public function show(){

        return view('Kelas.show', [
            'title' => 'Kelas',
            'active' => 'Kelas'
        ]);
    }
}
