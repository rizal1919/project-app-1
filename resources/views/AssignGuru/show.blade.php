@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Penugasan</h1>
</div>
<div class="container d-flex justify-content-center mt-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>Materi - {{ $penugasan['namaMateri'] }}</h4>
            </div>
            <div class="card-body">
                @if( $penugasan['idPenugasan'] === '' )
                    <p class="card-text"><strong>ID Penugasan : </strong>-</p>
                    <p class="card-text"><strong>Nama Guru : </strong><span class="badge rounded-pill text-bg-danger">{{ $penugasan['namaGuru'] }}</span></p>
                    <p class="card-text"><strong>Nama Aktivasi : </strong>{{ $penugasan['namaAktivasi'] }}</p>
                    <p class="card-text"><strong>Program / Materi : </strong>{{ $penugasan['namaProgram'] }} / {{ $penugasan['namaMateri'] }}</p>
                    <p class="card-text"><strong>Tanggal / Status : </strong>Materi belum memiliki guru</p>
                    <p class="card-text"><strong>Durasi Pertemuan : </strong>{{ $penugasan['durasiPertemuan'] }}</p>
                @else
                    <p class="card-text"><strong>ID Penugasan : </strong>{{ $penugasan['idPenugasan'] }}</p>
                    <p class="card-text"><strong>Nama Guru : </strong>{{ $penugasan['namaGuru'] }}</p>
                    <p class="card-text"><strong>Nama Aktivasi : </strong>{{ $penugasan['namaAktivasi'] }}</p>
                    <p class="card-text"><strong>Program / Materi : </strong>{{ $penugasan['namaProgram'] }} / {{ $penugasan['namaMateri'] }}</p>
                    <p class="card-text"><strong>Tanggal / Status : </strong>{{ $penugasan['tanggal'] }} / <span class="badge bg-primary">{{ $penugasan['status'] }}</span></p>
                    <p class="card-text"><strong>Durasi Pertemuan : </strong>{{ $penugasan['durasiPertemuan'] }}</p>
                @endif
            </div>
            <div class="card-footer text-end">
                <a href="/assign-teacher" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection