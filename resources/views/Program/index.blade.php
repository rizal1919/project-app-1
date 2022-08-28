@extends('Dashboard.Layouts.main')

@section('container')

    <div class="container mt-4">
        <div class="card p-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Program - Kurikulum {{ $kurikulum->nama_kurikulum }}</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-end mb-3">
                <div class="col-md-12 d-flex mt-4 justify-content-end">
                    <form action="/program/{{ $kurikulum->id }}" method="get" class="mx-2" style="width: 30%;" >
                        @csrf
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control text-start" placeholder="Nama Kurikulum">
                            <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                        </div>
                    </form>
                    <a href="/create/{{ $kurikulum->id }}" class="text-decoration-none text-light btn btn-primary"><i class="fa-solid fa-plus mx-1"></i>Tambah Program</a>
                    <a href="/kurikulum" class="btn btn-success text-decoration-none text-light mx-1">Kembali</a>
                </div>
            </div>
            
            @if( session('update') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi Program <strong>{{ session('update') }}</strong> telah berhasil diubah.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('destroy') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi Program <strong>{{ session('destroy') }}</strong> telah berhasil dihapus.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('destroyFailed') )
            <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
                Informasi Program <strong>{{ session('destroyFailed') }}</strong> gagal dihapus, silahkan hapus aktivasi terkait terlebih dahulu.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('create') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi Program <strong>{{ session('create') }}</strong> berhasil ditambahkan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card p-3 mt-2">
                <table class="table table-hover table-stripes">
                    <thead>
                        <th>No</th>
                        <th colspan="2">Program</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach( $programs as $program)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $program->nama_program }}</td>
                                <td>
                                <a href="/materi/{{ $program->id }}" class="text-decoration-none btn btn-primary" style="color: white;"><i class="fa-solid fa-plus mx-1"></i>Tambah Materi</a>
                                </td>
                                <td>
                                    <a href="/show-program/{{ $program->id }}" class="btn btn-info text-dark"><i class="fas fa-eye"></i></a>
                                    <a href="/update-program/{{ $program->id }}" class="btn btn-warning text-dark"><i class="fas fa-pen-to-square"></i></a>
                                    <button type="button" id="delete" data-url="/delete-program/" class="btn btn-danger text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="confirmation('{{ $program->id }}', '{{ $program->nama_program }}')"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-1">
                    {{ $programs->links('vendor.pagination.bootstrap-5') }}
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

    function confirmation(delId, namaProgram){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus program berjudul ' + '<strong>' + namaProgram +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>
@endpush