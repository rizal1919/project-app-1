<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index(){


        return view('Dashboard.Layouts.main', [
            'title' => 'Dashboard | ',
            'active' => 'Dashboard',
        ]);
    }

    public function exportPDF(){

        // $pdf = Pdf::loadView('Dashboard.datapdf');
        // return $pdf->download('filebaru.pdf');

        // $pdf = \Illuminate\Support\Facades\App::make('dompdf.wrapper');
        // $pdf->loadHTML('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Document</title></head><body> <div class="container" style="width: 100%; border: 2px solid red; margin-top: 10px; padding: 10px;"> <div class="sub-head" style="width: 40%; margin-right: 10px;"> <img src="img/gofood.jpg" class="img" style="display: inline-block; width: 50%;" alt="gofood"> <h3 style="width: 180px; height: 200px; border: 1px solid black;">PAS PHOTO</h3> </div> </div> <h1>Halow</h1> </body></html>');
        // return $pdf->stream();


        return view('Dashboard.datapdf', [
            'title' =>'New',
            'active' => 'Dashboard'
        ]);
    }   
}
