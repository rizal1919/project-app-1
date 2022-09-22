<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request){

        $teacher = Teacher::Filter(Request(['teacher_name']))->orderBy('updated_at', 'desc')->paginate(3)->withQueryString();

        return view('Guru.index', [
            'title' => 'Guru - ',
            'active' => 'Guru',
            'teachers' => $teacher
        ]);
    }

    public function show(Teacher $teacher){

        return view('Guru.show', [

            'title' => 'Guru - ',
            'active' => 'Guru',
            'teacher' => $teacher
        ]);
    }

    public function create(){

        return view('Guru.create', [

            'title' => 'Guru - ',
            'active' => 'Guru'
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([

            'teacher_name' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        Teacher::create($validatedData);

        return redirect('/teacher')->with('create', $validatedData['teacher_name']);
    }

    public function edit(Teacher $teacher){

        return view('Guru.update', [

            'title' => 'Guru - ',
            'active' => 'Guru',
            'teacher' => $teacher
        ]);
    }

    public function update(Request $request, Teacher $teacher){

        $validatedData = $request->validate([

            'teacher_name' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $teacher->update([
            'teacher_name' => $validatedData['teacher_name'],
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
        ]);

        return redirect('/teacher')->with('update', $validatedData['teacher_name']);
    }

    public function delete(Teacher $teacher){

        if( count(DB::table('assign_teachers')->where('teacher_id', $teacher->id)->get()) > 0){
            return redirect('/teacher')->with('deleteFailed', $teacher->teacher_name);
        }

        $teacher->delete();

        return redirect('/teacher')->with('delete', $teacher->teacher_name);
    }

}
