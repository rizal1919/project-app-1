
@extends('Layouts.main')

@include('Layouts/Navbar/navbar')
@section('content')

<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-lg-3" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY - KURIKULUM</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">ID : {{ $kurikulums->id }}</p>
                    <p class="card-text">Nama Program : {{ $kurikulums->nama_kurikulum }}</p>
                    <p class="card-text">Dibuat : {{ $kurikulums->created_at->diffForHumans() }}</p>
                </div>
                <button class="btn btn-primary mt-3 rounded-bottom" style="border-radius: 0px;">
                    <a href="/kurikulum" class="text-decoration-none" style="color: white;">Kembali</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection