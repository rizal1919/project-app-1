@extends('Layouts.main')

@include('Layouts/Navbar/navbar')

@section('content')
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-lg-5" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY - UPDATE KURIKULUM</h5>
                </div>
                <div class="card-body">
                <form action="/update/{{ $kurikulums->id }}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('nama_kurikulum') is-invalid @enderror" id="nama_kurikulum" name="nama_kurikulum" aria-describedby="emailHelp" value="{{ $kurikulums->nama_kurikulum }}" placeholder="Nama Kurikulum" autofocus required>
                        @error('nama_kurikulum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="nama_kurikulum" class="form-label">Nama Kurikulum</label>
                    </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen-to-square mx-1"></i>Ubah Nama Kurikulum</button>
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