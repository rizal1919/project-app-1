<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Program;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index(){
        return view('Materi.index', [
            'title' => 'Materi'
        ]);
    }

    public function indexMateri(Materi $materi){

        return view('Materi.index', [
            'title' => 'Materi',
            'dataMateri' =>  $materi->program->load('materi'),
        ]);
    }

    public function showMateri(Materi $materi){

        // $data = Program::where('id', $materi['program_id']);
        $id = $materi['id'];

        return view('Materi.show', [
            'title' => 'Materi',
            'dataMateri' => $materi->program->load('materi'),
            'id' => $id
        ]);
    }
}

