<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('Dashboard.index', [
            'title' => 'Dashboard Admin',
            'active' => 'Dashboard Admin'
        ]);
    }
}
