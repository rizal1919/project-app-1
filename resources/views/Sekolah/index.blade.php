@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Sekolah</h1>
</div>
    <div class="container">
        <div class="card p-4">
            <div class="card">
                <div class="card-header">
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
                                    <button class="btn btn-danger text-dark" onclick="confirmation('{{ $namaSekolah }}', '{{ $id }}')"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body mt-2">
                    {{ $dataSekolah->links('vendor.pagination.bootstrap-5') }}
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

    function confirmation(namaSekolah,delId){
    var del=confirm(`Anda yakin ingin menghapus data sekolah ${namaSekolah} ?`);
    if (del==true){
        window.location.href=`/sekolah-delete/${delId}`;
    }
    return del;
    }
</script>
@endpush