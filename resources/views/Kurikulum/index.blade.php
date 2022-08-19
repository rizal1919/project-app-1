@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-5" >
    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-lg-12 d-flex justify-content-center align-items-center mt-2">
            <div class="card" style="width: 100%;">
                <div class="card-header">
                    <h4 class="card-text"><i class="fa-solid fa-address-card mx-2"></i>Daftar Kurikulum</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Short Course Curriculums</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-11 text-end">
            
            <a href="/create-kurikulum" class="text-decoration-none text-light btn btn-primary"><i class="fa-solid fa-plus mx-1"></i>Tambah Kurikulum</a>
            

            <form action="/kurikulum" method="post" class="d-inline">
                @csrf
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control d-inline" style="width: 20%;" placeholder="Search">
                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
            </form>
        </div>
    </div>
    
</div>
<div class="row justify-content-center my-3">
    <div class="col-11">
        @if( session('update') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('update') }}</strong> Kurikulum telah berhasil diubah.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('destroy') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            Informasi kurikulum <strong>{{ session('destroy') }}</strong> telah berhasil dihapus.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('destroyFailed') )
        <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
            Informasi kurikulum <strong>{{ session('destroyFailed') }}</strong> tidak dapat dihapus, silahkan hapus siswa terdaftar terlebih dahulu.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('create') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('create') }}</strong> Kurikulum telah berhasil ditambahkan.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    </div>
</div>

<div class="row justify-content-center mt-1 mb-5">
    <div class="col-lg-11">
        <div class="card p-3">
            <table class="table table-light table-striped table-hover m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th colspan="2">Kurikulum</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach( $kurikulums as $kurikulum)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $kurikulum->nama_kurikulum }}</td>
                        <td></td>
                        <td>
                                <a href="/show/{{ $kurikulum->id }}" class="btn btn-info text-dark"><i class="fas fa-eye"></i></a>
                                <a href="/update/{{ $kurikulum->id }}" class="btn btn-warning text-dark"><i class="fas fa-pen-to-square"></i></a>
                                <button type="button" id="delete" data-url="/delete-kurikulum/" style="margin-right: 50px;" class="btn btn-danger text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="confirmation('{{ $kurikulum->id }}', '{{ $kurikulum->nama_kurikulum }}')"><i class="fas fa-trash"></i></button>
                                <a href="/program/{{ $kurikulum->id }}" class="text-decoration-none btn btn-primary" style="color: white;"><i class="fa-solid fa-plus mx-1"></i>Tambah Program</a>
                        </td>
                    </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body mt-2 mb-5">
            {{ $kurikulums->links('vendor.pagination.bootstrap-5') }}
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
    function confirmation(delId, namaKurikulum){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus kurikulum berjudul ' + '<strong>' + namaKurikulum +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>

@endpush


