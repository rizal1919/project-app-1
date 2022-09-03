@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Program</h1>
</div>
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 70px;">
        <div class="col-lg-6" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                <form action="/create" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('nama_program') is-invalid @enderror" id="nama_program" name="nama_program" value="{{ old('nama_program') }}" placeholder="Nama Program" autofocus required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                        @error('nama_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="nama_program">Nama Program</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-database mx-2"></i>Tambah Program Baru</button>
                </form>
                </div>
                
                <a href="/program" style="border-radius: 0px;" class="text-decoration-none btn btn-primary mt-3 rounded-bottom" style="color: white;">Kembali</a>
                
            </div>
        </div>
    </div>
</div>
@endsection