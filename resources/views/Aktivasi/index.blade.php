@extends('Dashboard.Layouts.main')

@section('container')

    <div class="container mt-4">
        <div class="card p-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Daftar Aktivasi</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-end mb-3">
                <div class="col-md-12 d-flex mt-4 justify-content-end">
                    <form action="/aktivasi" method="get" class="mx-2" style="width: 30%;" >
                        @csrf
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm text-start" placeholder="Nama Aktivasi">
                            <button class="btn btn-primary btn-sm" id="basic-addon2">Cari!</button>
                        </div>
                    </form>

                    @if( auth('teacher')->check() )
                    @else
                    <a href="/create-aktivasi" class="text-decoration-none text-light btn-sm btn-primary"><i class="fa-solid fa-plus mx-1"></i>Tambah Aktivasi</a>
                    @endif
                </div>
            </div>
            
            @if( session('update') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Aktivasi <strong>{{ session('update') }}</strong> telah berhasil diubah.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('destroy') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi aktivasi <strong>{{ session('destroy') }}</strong> telah berhasil dihapus.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('destroyFailed') )
            <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
                Informasi aktivasi <strong>{{ session('destroyFailed') }}</strong> tidak bisa terhapus, silahkan hapus siswa yang terdaftar terlebih dahulu.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('destroyFailedAssignment') )
            <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
                Informasi aktivasi <strong>{{ session('destroyFailedAssignment') }}</strong> tidak bisa terhapus, silahkan hapus pada halaman penugasan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('create') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Aktivasi program <strong>{{ session('create') }}</strong> telah berhasil ditambahkan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('createFailed') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('createFailed') }}</strong> belum ada program ditambahkan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card p-3 mt-2">
                <table class="table table-hover table-stripes">
                    <thead>
                        <th>No</th>
                        <th>Nama Aktivasi</th>
                        @if( auth('administrator')->check() )
                            <th>Biaya</th>
                        @endif
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach( $aktivasi as $aktif )
                            <tr>
                                
                                <td>{{ ($aktivasi->currentPage() - 1) * $aktivasi->perPage() + $loop->iteration }}</td>
                                <td>{{ $aktif->nama_aktivasi }}</td>
                                @if( auth('administrator')->check() )
                                    <td>{{ $aktif->biaya }}</td>
                                @endif
                                <td>{{ $aktif->pembukaan }} - {{ $aktif->penutupan }}</td>
                                @if( $aktif->status === 'Ditutup' )
                                    <td><p class="badge bg-dark text-light">{{ $aktif->status }}</p></td>
                                @else
                                    <td><p class="badge bg-primary text-light">{{ $aktif->status }}</p></td>
                                @endif
                                <td>
                                    <a href="/show-aktivasi-program/{{ $aktif->id }}" class="btn btn-info btn-sm text-dark"><i class="fas fa-eye"></i></a>
                                @if( auth('teacher')->check() )
                                @else
                                    <a href="/update-aktivasi-program/{{ $aktif->id }}" class="btn btn-warning btn-sm text-dark"><i class="fas fa-pen-to-square"></i></a>
                                    <button type="button" id="delete" data-url="/delete-aktivasi-program/" style="margin-right: 50px;" class="btn btn-danger btn-sm text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="confirmation('{{ $aktif->id }}', '{{ $aktif->nama_aktivasi }}')"><i class="fas fa-trash"></i></button>
                                @endif
                                    <a href="/details/{{ $aktif->id }}" class="btn btn-dark btn-sm"><i class="fa-solid fa-list-check mx-2"></i>Daftar Nilai</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-1">
                    {{ $aktivasi->links('vendor.pagination.bootstrap-5') }}
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

    function confirmation(delId, namaAktivasi){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus aktivasi berjudul ' + '<strong>' + namaAktivasi +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>
@endpush