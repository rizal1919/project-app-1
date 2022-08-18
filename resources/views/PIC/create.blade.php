@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Tambah PIC</h1>
</div>
<div class="container d-flex justify-content-center">
    <div class="col-8">
        <div class="card">
            <form action="/pic-store" method="post">
                @csrf
                <div class="card-header">
                    <h4>Tambah PIC</h4>
                </div>
                <div class="card-body">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('nama_pic') is-invalid @enderror" id="nama_pic" name="nama_pic" placeholder="nama_pic" required autofocus>
                        <label for="nama_pic">Nama PIC</label>
                        @error('nama_pic')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating my-2">
                        <input type="text" style="text-transform: uppercase" class="form-control @error('kode_referral') is-invalid @enderror" id="kode_referral" placeholder="kode_referral" name="kode_referral" required>
                        <label for="kode_referral">Kode Referal</label>
                        @error('kode_referral')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating my-2">
                        <input type="number" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" placeholder="nomor_telepon" name="nomor_telepon" required>
                        <label for="nomor_telepon">No Telfon</label>
                        @error('nomor_telepon')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <label for="sekolah_id" class="col-form-label">PILIHAN SEKOLAH</label>
                    <div class="col-auto"> 
                        <select name="sekolah_id" id="sekolah_id" class="p-1 bg-primary text-center text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">

                            <option value="0">Tidak memilih sekolah</option>
                            @foreach( $dataSekolah as $sekolah )
                                <option value="{{ $sekolah['id'] }}">{{ $sekolah['nama_sekolah'] }}</option>
                            @endforeach
                        
                        </select>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-primary mx-1"><i class="fas fa-database mx-2"></i>Tambah Data PIC</button>
                    <a href="/pic" class="text-decoration-none btn btn-primary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection