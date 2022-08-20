@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Edit Kelas</h1>
</div>
<div class="container d-flex justify-content-center">
    <div class="col-8">
        <div class="card">
            <form action="/classroom-update/{{ $classroom->id }}" method="post">
                @csrf
                <div class="card-header">
                    <h4>Edit Kelas</h4>
                </div>
                <div class="card-body">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('classroom_name') is-invalid @enderror" id="classroom_name" name="classroom_name" placeholder="Ruang Kelas" value="{{ old('classroom_name', $classroom->classroom_name) }}" required autofocus>
                        <label for="classroom_name">Nama Kelas</label>
                        @error('classroom_name')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-primary mx-1"><i class="fas fa-database mx-2"></i>Ubah Data Kelas</button>
                    <a href="/classroom" class="text-decoration-none btn btn-primary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection