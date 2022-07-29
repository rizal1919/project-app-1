@extends('Layouts.main')

@include('Layouts/Navbar/navbar')
@section('content')
<div class="container-lg">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-11">
        <div class="card p-3">
            <div class="card-header mb-1 rounded">
                <h4 class="card-title">Data Siswa - Program {{ $program->nama_program }}</h4>
            </div>
            <div class="card-body mb-1">
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 text-end">
                        <form action="/materi/" method="get" class="d-inline">
                            @csrf
                            <input type="text" id="search" name="search" class="form-control d-inline" style="width: 50%;" placeholder="Search">
                            <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                        </form>
                        <button class="btn btn-warning">
                            <a href="/kelas-admin" class="text-decoration-none text-light"> Update status</a>
                        </button>
                        <button class="btn btn-danger">
                            <a href="/kelas-admin" class="text-decoration-none text-light"> Hapus</a>
                        </button>
                        <button class="btn btn-primary">
                            <a href="/kelas-admin" class="text-decoration-none text-light"> Kembali</a>
                        </button>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="card p-3">
                    <table class="table table-light table-hover table-striped" style="border-radius: 5px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th >Program | ID Program</th>
                                <th>KTP</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tahun Diterima</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach( $dataSiswa as $dasis )
                            <tr>
                                <td>{{ $i; }}</td>
                                <td>{{ $dasis->nama_siswa }}</td>
                                <td>{{ $program->nama_program }} | {{ $program->id }}</td>
                                <td>{{ $dasis->ktp }}</td>
                                <td class="text-center"><span class="badge text-bg-primary">Diterima</span></td>
                                <td class="text-center">{{ $dasis->tahun_daftar }}</td>
                                <td>
                                    <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-warning"><i class="fas fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection