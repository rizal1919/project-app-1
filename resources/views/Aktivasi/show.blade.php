@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Detail Aktivasi</h1>
</div>
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 80px;">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY - SHORTCOURSE</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">ID : {{ $dataAktivasi->id }}</p>
                    <p class="card-text">Nama Program : {{ $dataAktivasi->program->nama_program }}</p>
                    <p class="card-text">Harga : {{ $dataAktivasi->harga }}</p>
                    <p class="card-text">Periode : {{ $dataAktivasi->periode }}</p>
                    <p class="card-text">Dibuat : {{ $dataAktivasi->created_at->diffForHumans() }}</p>
                </div>
                <a href="/aktivasi" class="text-decoration-none btn btn-primary mt-3 rounded-bottom" style="color: white; border-radius: 0px;">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection