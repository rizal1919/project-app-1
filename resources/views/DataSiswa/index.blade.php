@extends('Layouts.main')

@include('Layouts/Navbar/navbar')
@section('content')
<div class="container-lg">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-11">
        <div class="card p-3">
            <div class="card-header mb-1 rounded text-center">
                <h4 class="card-title">DATA SISWA-SISWI SC ACADEMY</h4>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 d-flex mt-4 justify-content-end">
                        <form action="/data-siswa" method="post" class="mx-2" style="width: 70%;" >
                            @csrf
                            <div class="input-group">
                                <input type="text" name="nama" value="{{ request()->nama }}" class="form-control text-end" placeholder="Nama">
                                <input type="text" name="ktp" value="{{  request()->ktp }}" class="form-control text-end" placeholder="No KTP">
                                <input type="text" name="tahun" value="{{ request()->tahun }}" class="form-control text-end" placeholder="Tahun">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
                        <!-- <button class="btn btn-warning">
                            <a href="/kelas-admin" class="text-decoration-none text-light"> Update status</a>
                        </button>
                        <button class="btn btn-danger">
                            <a href="/kelas-admin" class="text-decoration-none text-light"> Hapus</a>
                        </button> -->
                        <button class="btn btn-primary" style="width: 10%; height: 70%;">
                            <a href="/dashboard" class="text-decoration-none text-light self-align-center">
                                Kembali
                            </a>
                        </button>
                    </div>
                </div>
                @if( session('destroy') )
                <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                    <strong>{{ session('destroy') }}</strong> Data siswa telah berhasil dihapus.
                    <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="card p-3">
                    <table class="table table-light table-hover table-striped" style="border-radius: 5px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Email | ID Siswa</th>
                                <th>KTP</th>
                                <th class="text-center">Status (optional field)</th>
                                <th class="text-center">Tahun Diterima</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $dataSiswa as $dasis )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dasis->nama_siswa }}</td>
                                <td>{{ $dasis->email }} | {{ $dasis->nomor_pendaftaran }}</td>
                                <td>{{ $dasis->ktp }}</td>
                                <td class="text-center"><span class="badge text-bg-primary">Diterima</span></td>
                                <td class="text-center">{{ $dasis->tahun_daftar }}</td>
                                <td>
                                    <a href="/kelas-admin/show/student/{{ $dasis->id }}" class="btn btn-primary text-decoration-none"><i class="fas fa-eye"></i></a>
                                    <a href="/kelas-admin/update/student/{{ $dasis->id }}" class="btn btn-warning text-decoration-none text-light"><i class="fas fa-pen-to-square"></i></a>
                                    <!-- <a href="/kelas-admin/delete/student/{{ $dasis->id }}" class="btn btn-danger text-decoration-none text-light"><i class="fas fa-trash"></i></a> -->
                                    <button class="btn btn-danger text-light" onclick="confirmation('{{ $dasis->id }}')"><i class="fas fa-trash"></i></button>
                        
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $dataSiswa->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function changeStyle(){
        var element = document.getElementById("hide");
        element.style.display = "none";
    }
</script>
<script>
    function confirmation(delId){
    var del=confirm(`Anda yakin ingin menghapus siswa dengan id ${delId} ?`);
    if (del==true){
        window.location.href=`/kelas-admin/delete/student/${delId}`;
    }
    return del;
    }
</script>
@endpush