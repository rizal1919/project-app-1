@extends('Dashboard.Layouts.main')



@section('container')
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 80px;">
        <div class="col-lg-8" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                <form action="/store-kurikulum" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('nama_kurikulum') is-invalid @enderror" id="nama_kurikulum" name="nama_kurikulum" value="{{ old('nama_kurikulum') }}" placeholder="Nama Kurikulum" autofocus required>
                        @error('nama_kurikulum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="nama_kurikulum">Nama Kurikulum</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-database mx-2"></i>Tambah Kurikulum Baru</button>
                    </form>
                </div>
                <button class="btn btn-primary mt-3 rounded-bottom" style="border-radius: 0px;">
                    <a href="/kurikulum" class="text-decoration-none" style="color: white;">Kembali</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection