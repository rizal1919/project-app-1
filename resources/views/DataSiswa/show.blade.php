@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Detail {{ $active }}</h1>
</div>
<div class="container-lg mb-5  mt-5">
    <div class="row w-100 d-flex justify-content-center ">
        <div class="col-lg-12 d-flex flex-row justify-content-center ">
            <div class="card mx-1" style="width: 30%; margin-right: 50px;">
                <div class="card-body">
                       <img src="https://source.unsplash.com/300x300?man" class="card-img-top" alt="man">
                </div>
            </div>
            <div class="card mx-1" style="width: 25%;">
                <div class="card-body text-end">
                    <div class="mb-1 p-2 bg-info text-dark fw-bold rounded" style="border: 0px solid white;">
                        <h4 class="card-title">NAMA</h4>
                        <p class="card-text text-light">{{ $student->nama_siswa }}</p>
                    </div>
                    <div class="mb-1 p-2 bg-info text-dark fw-bold rounded" style="border: 0px solid gray;">
                        <h4 class="card-title">EMAIL</h4>
                        <p class="card-text text-light">{{ $student->email }}</p>
                    </div>
                    <div class="mb-1 p-2 bg-info text-dark fw-bold rounded" style="border: 0px solid gray;">
                        <h4 class="card-title">NO KTP</h4>
                        <p class="card-text text-light">{{ $student->ktp }}</p>
                    </div>
                    <div class="mb-1 p-2 bg-info text-dark fw-bold rounded" style="border: 0px solid gray;">
                        <h4 class="card-title">TANGGAL LAHIR</h4>
                        <p class="card-text text-light">{{ $student->tanggal_lahir }}</p>
                    </div>
                </div>
            </div>
            <div class="card mx-1" style="width: 25%;">
                <div class="card-body">
                    <div class="mb-1 p-2 bg-info text-dark fw-bold rounded" style="border: 0px solid gray;">
                        <h4 class="card-title">KELAS</h4>
                        <p class="card-text text-light">{{ $student->kurikulum->nama_kurikulum }}</p>
                    </div>
                    <div class="mb-1 p-2 bg-info text-dark fw-bold rounded" style="border: 0px solid gray;">
                        <h4 class="card-title">ID SISWA</h4>
                        <p class="card-text text-light">{{ $student->nomor_pendaftaran }}</p>
                    </div>
                    <div class="mb-1 p-2 bg-info text-dark fw-bold rounded" style="border: 0px solid gray;">
                        <h4 class="card-title">TAHUN DITERIMA</h4>
                        <p class="card-text text-light">{{ $student->tahun_daftar }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8 text-center d-flex justify-content-end mt-5">
            <button class="btn btn-primary d-flex justify-content-center">
                <a href="/data-siswa" class="btn btn-primary text-decoration-none text-light">
                    Kembali
                </a>
            </button>
        </div>
    </div>
</div>
@endsection