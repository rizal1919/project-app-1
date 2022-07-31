@extends('Layouts.main')


@include('Layouts/Navbar/navbar')

@section('content')
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 80px;">
        <div class="col-lg-3" style="height: 30%;">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <button class="btn btn-primary mt-3 rounded-bottom" style="border-radius: 0px;">
                    <a href="/program" class="text-decoration-none" style="color: white;">Kembali</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection