@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Penugasan</h1>
</div>
<div class="container d-flex justify-content-center mt-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>ACADEMY - TEACHER ASSIGNMENT</h4>
            </div>
            <div class="card-body">
                <p class="card-text"><strong> ID : </strong>{{ $penugasan['idPenugasan'] }}</p>
                <p class="card-text"><strong>Nama Guru : </strong>{{ $penugasan['teacher_name'] }}</p>
                <p class="card-text"><strong>Program Aktivasi : </strong>{{ $penugasan['nama_aktivasi'] }}</p>
                <p class="card-text"><strong>Materi : </strong>{{ $penugasan['nama_materi'] }}</p>
                <p class="card-text"><strong>Tanggal / Status : </strong>{{ $penugasan['tanggal'] }} / <span class="badge bg-primary">{{ $penugasan['status'] }}</span></p>
                <p class="card-text"><strong>Pertemuan : </strong>{{ $penugasan['pertemuan'] }}</p>
            </div>
            <div class="card-footer text-end">
                <a href="/assign-teacher" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection