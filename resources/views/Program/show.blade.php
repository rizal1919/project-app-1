
@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Program</h1>
</div>
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-lg-8" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>ID :</strong> {{ $programs->id }}</p>
                    <p class="card-text"><strong>Nama Program :</strong> {{ $programs->nama_program }}</p>
                    <p class="card-text"><strong>Dibuat :</strong> {{ $programs->created_at->diffForHumans() }}</p>
                </div>
                <a href="/program/{{ $programs->kurikulum_id }}" class="text-decoration-none btn btn-primary mt-3 rounded-bottom" style="color: white; border-radius: 0px;">Kembali</a>
                
            </div>
        </div>
    </div>
</div>
@endsection