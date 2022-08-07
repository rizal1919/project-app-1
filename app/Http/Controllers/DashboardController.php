<?php

namespace App\Http\Controllers;

use App\Models\UserAdmin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        

        return view('Dashboard.index', [
            'title' => 'Dashboard | ',
            'active' => 'Dashboard',
            'admins' => UserAdmin::all()
        ]);
    }
}
