
@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Materi</h1>
</div>
<div class="container-lg mt-6">
    <div class="row justify-content-center" style="margin-top: 70px;">
        <div class="col-lg-6" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                   
                        <p class="card-text"><strong>ID :</strong> {{ $dataMateri->id }}</p>
                        <p class="card-text"><strong>Program :</strong> {{ $program->nama_program }}</p>
                        <p class="card-text"><strong>Nama Materi :</strong> {{ $dataMateri->nama_materi }}</p>
                        <p class="card-text"><strong>Dibuat :</strong> {{ $dataMateri->created_at->diffForHumans() }}</p>
                    
                </div>
                <a href="/materi/{{ $dataMateri->id }}" style="border-radius: 0px;" class="btn btn-primary mt-3 rounded-bottom text-decoration-none" style="color: white;">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection