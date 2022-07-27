
@extends('Layouts.main')

@include('Layouts/Navbar/navbar')
@section('content')
<div class="container-lg">
    <div class="row justify-content-center" style="margin-top: 50px;">
        <div class="col-lg-3" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                <form action="/create-materi" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('nama_materi') is-invalid @enderror" id="nama_materi" name="nama_materi" value="{{ old('nama_materi') }}" placeholder="Nama Materi" autofocus required>
                        @error('nama_materi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="nama_materi">Nama Materi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('jumlah_pertemuan') is-invalid @enderror" id="jumlah_pertemuan" name="jumlah_pertemuan" value="{{ old('jumlah_pertemuan') }}" placeholder="Jumlah Pertemuan" autofocus required>
                        @error('jumlah_pertemuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="jumlah_pertemuan">Jumlah Pertemuan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('menit') is-invalid @enderror" id="menit" name="menit" value="{{ old('menit') }}" placeholder="Menit" autofocus required>
                        @error('menit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="menit">Menit</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="hidden" class="form-control @error('program_id') is-invalid @enderror" id="program_id" name="program_id" value="{{ $dataMateri->id }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <button class="btn btn-primary mt-3 rounded-bottom" style="border-radius: 0px;">
                    <a href="/materi/{{ $dataMateri->id }}" class="text-decoration-none" style="color: white;">Kembali</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection