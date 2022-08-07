
@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Program</h1>
</div>
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 150px;">
        <div class="col-lg-8" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">ID : {{ $programs->id }}</p>
                    <p class="card-text">Nama Program : {{ $programs->nama_program }}</p>
                    <p class="card-text">Dibuat : {{ $programs->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="container-fluid d-flex justify-content-center">
                <a href="/program/{{ $programs->kurikulum_id }}" class="col-lg-12 mt-1 btn btn-primary text-decoration-none" style="color: white;">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection