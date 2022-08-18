@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Tambah Sekolah</h1>
</div>
<div class="container d-flex justify-content-center">
    <div class="col-8">
        <div class="card">
            <form action="/sekolah/store" method="post">
                @csrf
                <div class="card-header">
                    <h4>Tambah Sekolah</h4>
                </div>
                <div class="card-body">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah" name="nama_sekolah" placeholder="nama_sekolah" required autofocus>
                        <label for="nama_sekolah">Nama Sekolah</label>
                        @error('nama_sekolah')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating my-2">
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="alamat" name="alamat" required>
                        <label for="alamat">Alamat Sekolah</label>
                        @error('alamat')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-primary mx-1"><i class="fas fa-database mx-2"></i>Tambah Data Sekolah</button>
                    <a href="/sekolah" class="text-decoration-none btn btn-primary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection