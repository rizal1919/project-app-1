@extends('Dashboard.Layouts.main')

@section('container')
    <div class="container mt-4">
        <div class="card p-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>PENUGASAN GURU</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-end mb-3">
                <div class="col-md-12 d-flex mt-4 justify-content-end">
                    <form action="/assign-teacher" method="get" class="mx-2" style="width: 30%;" >
                        @csrf
                        <div class="input-group">
                            <input type="text" name="teacher_name" value="{{ request()->teacher_name }}" class="form-control text-start" placeholder="Nama Guru">
                            <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                        </div>
                    </form>
                    <a href="/assign-teacher-create" class="btn btn-primary" style="width: 20%;"><i class="fas fa-plus mx-2"></i>Tugaskan Guru</a>
                </div>
            </div>
            
            @if( session('create') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('create') }}</strong> telah berhasil ditugaskan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if( session('update') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi kelas <strong>{{ session('update') }}</strong> telah berhasil diubah
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('deleteFailed') )
            <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
                Silahkan hapus PIC untuk sekolah <strong>{{ session('deleteFailed') }}</strong> terlebih dahulu
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('delete') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('delete') }}</strong> Informasi penugasan guru telah berhasil dihapus
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card p-3 mt-2">
                <table class="table table-hover table-light table-stripes">
                    <thead>
                        <th>No</th>
                        <th>Materi</th>
                        <th>Aktivasi</th>
                        <th>Status</th>
                        <th>Ditugaskan</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach( $dataGuru as $data )
                            @if( $data['statusPenugasan'] === 'empty' )
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['namaMateri'] }}</td>
                                    <td>{{ $data['namaAktivasi'] }}</td>
                                    <td>{{ $data['statusPelaksanaan'] }}</td>
                                    <td><p class="badge rounded-pill text-bg-danger">{{ $data['statusPenugasan'] }}</p></td>
                                    <td>
                                        <a href="#" class="text-decoration-none btn btn-info">Read</a>
                                        <a href="#" class="text-decoration-none btn btn-warning">Edit</a>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['namaMateri'] }}</td>
                                    <td>{{ $data['namaAktivasi'] }}</td>
                                    <td>{{ $data['statusPelaksanaan'] }}</td>
                                    <td>{{ $data['statusPenugasan'] }}</td>
                                    <td>
                                        <a href="#" class="text-decoration-none btn btn-info">Read</a>
                                        <a href="#" class="text-decoration-none btn btn-warning">Edit</a>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                {{ $dataGuru->links('vendor.pagination.bootstrap-5') }}
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

    function confirmation(delId, namaGuru){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus guru bernama ' + '<strong>' + namaGuru +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>
@endpush