@extends('Dashboard.Layouts.main')

@section('container')
    <div class="container mt-4">
        <div class="card p-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>PENUGASAN GURU</h4>
                </div>
            </div>
            <div class="row g-1 d-flex justify-content-end my-3">
                <div class="col-sm-9">
                    <form action="/assign-teacher" method="get">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="teacher_name" name="teacher_name" value="{{ request()->teacher_name }}" class="form-control form-control-sm text-start" placeholder="Nama Guru">
                            <input type="text" id="nama_aktivasi" name="nama_aktivasi" value="{{ request()->nama_aktivasi }}" class="form-control form-control-sm text-start" placeholder="Nama Aktivasi">
                            <input type="text" id="nama_materi" name="nama_materi" value="{{ request()->nama_materi }}" class="form-control form-control-sm text-start" placeholder="Nama Materi">
                            <select name="search" id="search" value="{{ request()->search }}" class="form-select form-select-sm">
                                <option selected disabled>Filter By</option>
                                <option value="Belum Terlaksana">Pertemuan - Belum Terlaksana</option>
                                <option value="Selesai">Pertemuan - Selesai Dilaksanakan</option>
                                <option value="0">Penugasan - Belum Ditugaskan</option>
                                <option value="1">Penugasan - Ditugaskan</option>
                            </select>
                            <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-1">
                    <button id="yes-here" class="btn btn-warning" data-toggle="tooltip" title="Click to Clear Filters"><i class="fa-solid fa-square-minus"></i></button>
                </div>
                <div class="col-sm-2">
                    <a href="/assign-teacher-create" class="text-decoration-none btn btn-primary"><i class="fas fa-plus mx-2"></i>Tugaskan Guru</a>
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
                <strong>{{ session('update') }}</strong> data penugasan berhasil diubah
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('updateFailed') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('updateFailed') }}</strong> materi sudah ada guru
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
                        <th>Status Pertemuan</th>
                        <th>Ditugaskan</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach( $dataGuru as $data )
                            @if( $data['statusPenugasan'] === 0 )

                                <?php $data['statusPenugasan'] = 'empty'; ?>
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['namaMateri'] }}</td>
                                    <td>{{ $data['namaAktivasi'] }}</td>
                                    <td>{{ $data['statusPelaksanaan'] }}</td>
                                    <td><p class="badge rounded-pill text-bg-danger">{{ $data['statusPenugasan'] }}</p></td>
                                    <td>
                                        <a href="/assign-teacher-show/{{ $data['idMateri'] }}" class="text-decoration-none btn btn-info"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-warning" data-toggle="tooltip" title="Materi belum memiliki guru" onclick="alert('Tugaskan guru terlebih dulu')"><i class="fas fa-pen-to-square"></i></button>
                                        <button class="btn btn-danger text-dark" onclick="alert('Tugaskan guru terlebih dulu')" data-toggle="tooltip" title="Materi belum memiliki guru"><i class="fas fa-trash"></i></button>
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
                                        <?php $idmateri = $data['idMateri']; ?>
                                        <?php $namaMateri = $data['namaMateri']; ?>
                                        <a href="/assign-teacher-show/{{ $data['idMateri'] }}" class="text-decoration-none btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="/assign-teacher-update/{{ $data['idMateri'] }}" class="text-decoration-none btn btn-warning"><i class="fas fa-pen-to-square"></i></a>
                                        <button type="button" id="delete" class="btn btn-danger text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-url="/assign-teacher-delete/" onclick="confirmation('{{ $idmateri }}', '{{ $namaMateri }}')"><i class="fas fa-trash"></i></button>
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

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    // const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    // const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

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
        comment.innerHTML = '<p> Anda yakin ingin menghapus penugasan materi ' + '<strong>' + namaMateri +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }

    let clear = document.getElementById('yes-here');
    
    clear.addEventListener("click", function(){
        
        console.log(window.location.href);
        window.history.pushState("", "", '/assign-teacher');
        let aktivasi = document.getElementById('nama_aktivasi');
        let guru = document.getElementById('teacher_name');
        let materi = document.getElementById('nama_materi');

        aktivasi.value = '';
        guru.value = '';
        materi.value = '';
        
        
        
    });
</script>
@endpush