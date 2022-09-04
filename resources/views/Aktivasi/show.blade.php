@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Detail Aktivasi</h1>
</div>
<div class="container-lg my-5">
    <div class="row justify-content-center" >
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">AKTIVASI - {{ $dataAktivasi->nama_aktivasi }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong> ID :</strong> {{ $dataAktivasi->id }}</p>
                    <p class="card-text mt-3"><strong>Harga :</strong> {{ $dataAktivasi->biaya }}</p>
                    <p class="card-text"><strong>Periode :</strong> {{ $dataAktivasi->pembukaan }} - {{ $dataAktivasi->penutupan }}</p>
                    <p class="card-text"><strong>Status :</strong> {{ $dataAktivasi->status }}</p>
                    <p class="card-text"><strong>Daftar Program :</strong></p>
                    <ul class="list-group col-lg-5">
                        @foreach( $dataAktivasi->program as $program )
                            <ol class="list-group-item text-bg-primary">{{ $program->nama_program }}</ol>
                        @endforeach
                    </ul>
                </div>
                <a href="/aktivasi" class="text-decoration-none btn btn-primary mt-3 rounded-bottom" style="color: white; border-radius: 0px;">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection