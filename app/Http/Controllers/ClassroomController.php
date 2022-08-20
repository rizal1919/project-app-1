<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index(Request $request){

        $classrooms = Classroom::Filter(Request(['classroom_name']))->orderBy('updated_at', 'desc')->paginate(3)->withQueryString();

        return view('RuangKelas.index', [
            'title' => 'Ruang Kelas - ',
            'active' => 'Ruang Kelas',
            'classrooms' => $classrooms
        ]);
    }

    public function show(Classroom $classroom){

        return view('RuangKelas.show', [

            'title' => 'Ruang Kelas - ',
            'active' => 'Ruang Kelas',
            'classroom' => $classroom
        ]);
    }

    public function create(){

        return view('RuangKelas.create', [

            'title' => 'Ruang Kelas - ',
            'active' => 'Ruang Kelas',
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([

            'classroom_name' => 'required'
        ]);

        Classroom::create($validatedData);

        return redirect('/classroom')->with('create', $validatedData['classroom_name']);
    }

    public function edit(Classroom $classroom){

        return view('RuangKelas.update', [

            'title' => 'Ruang Kelas - ',
            'active' => 'Ruang Kelas',
            'classroom' => $classroom
        ]);
    }

    public function update(Request $request, Classroom $classroom){

        $validatedData = $request->validate([

            'classroom_name' => 'required'
        ]);

        $classroom->update([
            'classroom_name' => $validatedData['classroom_name']
        ]);

        return redirect('/classroom')->with('update', $validatedData['classroom_name']);
    }

    public function delete(Classroom $classroom){

        $classroom->delete();

        return redirect('/classroom')->with('delete', $classroom->classroom_name);
    }
}
