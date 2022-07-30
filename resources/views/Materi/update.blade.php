@extends('Layouts.main')

@include('Layouts/Navbar/navbar')
@section('content')
<div class="container-lg">
    <div class="row justify-content-center" style="margin-top: 0px;">
        <div class="col-lg-3" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                @foreach( $dataMateri->materi as $t )
                    @if( $t['id'] === $id )
                <form action="/update-materi/{{ $t->id }}" method="post">
                    @csrf
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control @error('nama_materi') is-invalid @enderror" id="nama_materi" name="nama_materi" value="{{ $t->nama_materi }}" placeholder="Nama Materi" autofocus required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                        @error('nama_materi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="nama_materi">Nama Materi</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="number" class="form-control @error('jumlah_pertemuan') is-invalid @enderror" id="jumlah_pertemuan" name="jumlah_pertemuan" value="{{ $t->jumlah_pertemuan }}" placeholder="Jadwal Pertemuan" required>
                        @error('jumlah_pertemuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="jumlah_pertemuan">Jumlah Pertemuan</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="number" class="form-control @error('menit') is-invalid @enderror" id="menit" name="menit" value="{{ $t->menit }}" placeholder="Menit" required>
                        @error('menit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <label for="menit">Durasi Pertemuan (menit)</label>
                    </div>
                    <div class="mb-1">
                        <input type="hidden" class="form-control @error('program_id') is-invalid @enderror" id="program_id" name="program_id" value="{{ $t->program_id }}" required>
                    </div>
                        <button type="submit" class="btn btn-primary mb-3">Submit</button>
                    </form>
                    @endif
                    
                @endforeach
                </div>
                <button class="btn btn-primary mt-3 rounded-bottom" style="border-radius: 0px;">
                    <a href="/materi/{{ $dataMateri->id }}" class="text-decoration-none" style="color: white;">Kembali</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection