
@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Materi</h1>
</div>
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 0px;">
        <div class="col-lg-8" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Program {{ $dataProgram->nama_program }}</h5>
                </div>
                <div class="card-body">
                <form action="/create-materi" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control form-control-sm @error('nama_materi') is-invalid @enderror" id="nama_materi" name="nama_materi" value="{{ old('nama_materi') }}" placeholder="Nama Materi" autofocus required>
                        @error('nama_materi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="nama_materi">Nama Materi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" min="30" max="240" class="form-control form-control-sm @error('menit') is-invalid @enderror" id="menit" name="menit" value="{{ old('menit') }}" placeholder="Menit" required>
                        @error('menit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="menit">Menit</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" max="{{ $bobot }}" name="bobot_persen" placeholder="Bobot Penilaian (%)" id="bobot_persen" value="{{ old('bobot_persen') }}" class="form-control @error('bobot_persen') is-invalid @enderror">
                        @error('bobot_persen')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <label for="bobot_persen">Bobot Penilaian (%)</label>
                        <p class="form-text px-1">Total bobot penilaian saat ini : {{ $total }}%</p>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="hidden" class="form-control @error('program_id') is-invalid @enderror" id="program_id" name="program_id" value="{{ $dataProgram->id }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-database mx-2"></i>Tambah Materi Baru</button>
                    </form>
                </div>
                
                <a href="/materi/{{ $dataProgram->id }}" style="border-radius: 0px;" class="text-decoration-none btn btn-primary mt-3 rounded-bottom" style="color: white;">Kembali</a>
                
            </div>
        </div>
    </div>
</div>
@endsection