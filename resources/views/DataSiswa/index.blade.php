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
                        Informasi siswa bernama <strong>{{ session('destroy') }}</strong> telah berhasil dihapus.
                        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if( session('destroyFailed') )
                    <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                        Informasi siswa gagal dihapus karena masih tertaut pada <strong>{{ session('destroyFailed') }}</strong>!
                        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if( session('pendaftaranBerhasil') )
                    <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                        <strong>{{ session('pendaftaranBerhasil') }}</strong> adalah nomor pendaftaran siswa.
                        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 d-flex mt-4 justify-content-end">
                        <form action="/data-siswa" method="get" class="mx-2" style="width: 80%;" >
                            @csrf
                            <div class="input-group">
                                <input type="text" name="nama" value="{{ request()->nama }}" class="form-control text-end" placeholder="Nama">
                                <input type="text" name="ktp" value="{{  request()->ktp }}" class="form-control text-end" placeholder="No KTP">
                                <input type="text" name="tahun" value="{{ request()->tahun }}" class="form-control text-end" placeholder="Tahun">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
                        <a href="/data-siswa/create/student" class="btn btn-primary mx-1" style="width: 20%; height: 100%;">Tambah Siswa</a>
                        
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
                                    <td class="text-center">{{ $dasis->tahun_daftar }}</td>
                                    <td>
                                        <a href="/data-siswa/show/student/{{ $dasis->id }}" class="btn btn-info text-decoration-none text-dark"><i class="fas fa-eye"></i></a>
                                        <a href="/data-siswa/update/student/{{ $dasis->id }}" class="btn btn-warning text-decoration-none text-dark"><i class="fas fa-pen-to-square"></i></a>
                                        <!-- <button class="btn btn-danger text-dark border-0" onclick="confirmation('{{ $dasis->nama_siswa }}')"><i class="fas fa-trash"></i></button> -->
                                        <button type="button" id="delete" data-url="/data-siswa/delete/student/" class="btn btn-danger text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="confirmation('{{ $dasis->id }}', '{{ $dasis->nama_siswa }}')"><i class="fas fa-trash"></i></button>
                            
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

<!-- Delete Warning Modal -->
<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" id="forms" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-trash mx-2"></i>Hapus Data
                </h5>
                <input type="hidden" id="name" name="id">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <p id="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Ya, Hapus!</button>
            </div>
        </form>
    </div>
</div>
<!-- End Delete Modal --> 
@endsection

@push('js')
<script>
function changeStyle(){
        var element = document.getElementById("hide");
        element.style.display = "none";
    }
</script>
<script>
    function confirmation(delId, namaSiswa){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus siswa bernama ' + '<strong>' + namaSiswa +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>
@endpush