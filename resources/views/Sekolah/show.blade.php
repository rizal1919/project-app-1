@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Sekolah</h1>
</div>
<div class="container d-flex justify-content-center mt-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ $dataSekolah->nama_sekolah }}</h4>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>ID :</strong> {{ $dataSekolah->id }}</p>
                <p class="card-text"><strong>Alamat :</strong> {{ $dataSekolah->alamat }}</p>
            </div>
            <div class="card-footer text-end">
                <a href="/sekolah" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection