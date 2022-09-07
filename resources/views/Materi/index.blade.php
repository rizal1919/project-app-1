@extends('Dashboard.Layouts.main')

@section('container')

    <div class="container mt-4">
        <div class="card p-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Materi - Program {{ $dataProgram->nama_program }}</h4>
                </div>
            </div>
            <div class="row g-1 my-3 d-flex justify-content-end">
                <div class="col-md-3">
                    <form action="/materi/{{ $dataProgram->id }}" method="get">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control text-start" placeholder="Nama Materi">
                            <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2 text-center">
                    <a href="/create-materi/{{ $dataProgram->id }}" class="text-decoration-none text-light btn btn-primary"><i class="fa-solid fa-plus"></i>Tambah Materi</a>
                </div>
                <div class="col-md-1 text-center">
                    <a href="/program" class="text-decoration-none text-light btn btn-primary">Kembali</a>
                </div>
            </div>
            
            @if( session('update') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi Materi <strong>{{ session('update') }}</strong> telah berhasil diubah.
                <button type="button" class="btn-close" id="matikan" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('destroy') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi Materi <strong>{{ session('destroy') }}</strong> telah berhasil dihapus.
                <button type="button" class="btn-close" id="matikan" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('destroyFailed') )
            <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
                Informasi Materi <strong>{{ session('destroyFailed') }}</strong> gagal dihapus karena masih tertaut pada halaman penugasan guru.
                <button type="button" class="btn-close" id="matikan" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('success') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi Materi <strong>{{ session('success') }}</strong> Materi telah berhasil ditambahkan.
                <button type="button" class="btn-close" id="matikan" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card p-3 mt-2">
                <table class="table table-hover table-stripes">
                    <thead>
                        <th>No</th>
                        <th>Materi</th>
                        <th>Menit</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach( $dataMateri as $materis )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $materis->nama_materi }}</td>
                                <td>{{ $materis->menit }}</td>
                                <td>
                                    <?php $id = $materis->id; ?>
                                    <a href="/show-materi/{{ $materis->id }}" class="btn btn-info text-decoration-none text-dark"><i class="fas fa-eye"></i></a>
                                    <a href="/update-materi/{{ $materis->id }}" class="btn btn-warning text-decoration-none text-dark"><i class="fas fa-pen-to-square"></i></a>
                                    <button type="button" id="delete" data-url="/delete-materi/" class="btn btn-danger text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="confirmation('{{ $materis->id }}', '{{ $materis->nama_materi }}')"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-1">
                    {{ $dataMateri->links('vendor.pagination.bootstrap-5') }}
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

    function confirmation(delId, namaMateri){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus materi berjudul ' + '<strong>' + namaMateri +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>
@endpush