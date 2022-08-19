@extends('Dashboard.Layouts.main')

@section('container')

    <div class="container mt-4">
        <div class="card p-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Sekolah-Sekolah Tujuan</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-end mb-3">
                <div class="col-md-12 d-flex mt-4 justify-content-end">
                    <form action="/sekolah" method="get" class="mx-2" style="width: 30%;" >
                        @csrf
                        <div class="input-group">
                            <input type="text" name="nama_sekolah" value="{{ request()->nama_sekolah }}" class="form-control text-start" placeholder="Nama Sekolah">
                            <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                        </div>
                    </form>
                    <a href="/sekolah/create" class="btn btn-primary" style="width: 20%;"><i class="fas fa-plus mx-2"></i>Tambah Sekolah</a>
                </div>
            </div>
            
            @if( session('create') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi data <strong>{{ session('create') }}</strong> telah berhasil ditambahkan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if( session('update') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi data <strong>{{ session('update') }}</strong> telah berhasil diubah.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('deleteFailed') )
            <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
                Silahkan hapus PIC untuk sekolah <strong>{{ session('deleteFailed') }}</strong> terlebih dahulu.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('delete') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi data <strong>{{ session('delete') }}</strong> telah berhasil dihapus.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card p-3 mt-2">
                <table class="table table-hover table-stripes">
                    <thead>
                        <th>No</th>
                        <th>Nama Sekolah</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach( $dataSekolah as $sekolah )
                            <tr>
                                <?php $namaSekolah = $sekolah->nama_sekolah; ?>
                                <?php $id = $sekolah->id; ?>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sekolah->nama_sekolah }}</td>
                                <td>{{ $sekolah->alamat }}</td>
                                <td>
                                    <a href="/sekolah-show/{{ $sekolah->id }}" class="text-decoration-none btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="/sekolah-update/{{ $sekolah->id }}" class="text-decoration-none btn btn-warning"><i class="fas fa-pen-to-square"></i></a>
                                    <button type="button" id="delete" data-url="/sekolah-delete/" class="btn btn-danger text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="confirmation('{{ $sekolah->id }}', '{{ $sekolah->nama_sekolah }}')"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">
                    {{ $dataSekolah->links('vendor.pagination.bootstrap-5') }}
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

    function confirmation(delId, namaSekolah){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus data sekolah ' + '<strong>' + namaSekolah +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>
@endpush