@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
        <div class="card p-3">
            <div class="card-header mb-1 rounded text-center">
                <h4 class="card-title">DATA SISWA-SISWI SC ACADEMY</h4>
            </div>
            <div class="card-body">
                @if( session('destroy') )
                    <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                        <strong>{{ session('destroy') }}</strong> Data siswa telah berhasil dihapus.
                        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 d-flex mt-4 justify-content-end">
                        <form action="/data-siswa" method="get" class="mx-2" style="width: 90%;" >
                            @csrf
                            <div class="input-group">
                                <input type="text" name="nama" value="{{ request()->nama }}" class="form-control text-end" placeholder="Nama">
                                <input type="text" name="nama_kurikulum" value="{{ request()->nama_kurikulum }}" class="form-control text-end" placeholder="Kurikulum">
                                <input type="text" name="ktp" value="{{  request()->ktp }}" class="form-control text-end" placeholder="No KTP">
                                <input type="text" name="tahun" value="{{ request()->tahun }}" class="form-control text-end" placeholder="Tahun">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
                        <button class="btn btn-primary" style="width: 10%; height: 100%;">
                            <a href="/dashboard" class="text-decoration-none text-light self-align-center">
                                Kembali
                            </a>
                        </button>
                    </div>
                </div>
                
            </div>
            <div class="card-body">
                <div class="card p-3">
                    <table class="table table-light table-hover table-striped" style="border-radius: 5px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>ID Siswa</th>
                                <th>KTP</th>
                                <th>Kurikulum</th>
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
                                    <td>{{ $dasis->nomor_pendaftaran }}</td>
                                    <td>{{ $dasis->ktp }}</td>
                                    <td>{{ $students->find($dasis['id'])->kurikulum->nama_kurikulum }}</td>
                                    <td class="text-center"><span class="badge text-bg-primary">{{ $dasis->status }}</span></td>
                                    <td class="text-center">{{ $dasis->tahun_daftar }}</td>
                                    <td>
                                        <a href="/data-siswa/show/student/{{ $dasis->id }}" class="badge bg-info text-decoration-none text-dark"><i class="fas fa-eye"></i></a>
                                        <a href="/data-siswa/update/student/{{ $dasis->id }}" class="badge bg-warning text-decoration-none text-dark"><i class="fas fa-pen-to-square"></i></a>
                                        <!-- <a href="/kelas-admin/delete/student/{{ $dasis->id }}" class="badge badge-danger text-decoration-none text-light"><i class="fas fa-trash"></i></a> -->
                                        <button class="badge bg-danger text-dark border-0" onclick="confirmation('{{ $dasis->nama_siswa }}')"><i class="fas fa-trash"></i></button>
                            
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
    var del=confirm(`Anda yakin ingin menghapus siswa bernama ${delId} ?`);
    if (del==true){
        window.location.href=`/data-siswa/delete/student/${delId}`;
    }
    return del;
    }
</script>
@endpush