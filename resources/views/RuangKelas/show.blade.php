@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Kelas</h1>
</div>
<div class="container d-flex justify-content-center mt-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>ACADEMY - CLASSROOM</h4>
            </div>
            <div class="card-body">
                <p class="card-text">ID : {{ $classroom->id }}</p>
                <p class="card-text">Nama Kelas : {{ $classroom->classroom_name }}</p>
                <p class="card-text">Dibuat : {{ $classroom->created_at->diffForHumans() }}</p>
            </div>
            <div class="card-footer text-end">
                <a href="/classroom" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection