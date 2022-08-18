@extends('Dashboard.Layouts.main')

@section('container')

    <div class="container mt-4">
        <div class="card p-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>PIC (Person In Charge)</h4>
                </div>
            </div>
            <div class="row d-flex justify-content-end mb-3">
                <div class="col-md-12 d-flex mt-4 justify-content-end">
                    <form action="/pic" method="get" class="mx-2" style="width: 30%;" >
                        @csrf
                        <div class="input-group">
                            <input type="text" name="nama_pic" value="{{ request()->nama_pic }}" class="form-control text-start" placeholder="Nama PIC">
                            <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                        </div>
                    </form>
                    <a href="/pic-create" class="btn btn-primary" style="width: 20%;"><i class="fas fa-plus mx-2"></i>Tambah PIC</a>
                </div>
            </div>
            
            @if( session('create') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi PIC atas nama <strong>{{ session('create') }}</strong> telah berhasil ditambahkan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('update') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi PIC atas nama <strong>{{ session('update') }}</strong> telah berhasil diubah.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('delete') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi PIC atas nama <strong>{{ session('delete') }}</strong> telah berhasil dihapus.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card p-3 mt-2">
                <table class="table table-hover table-stripes">
                    <thead>
                        <th>No</th>
                        <th>Nama PIC</th>
                        <th>Kode Referal</th>
                        <th>No. Telp</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach( $dataPIC as $pic )
                            <tr>
                                
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pic->nama_pic }}</td>
                                <td>{{ $pic->kode_referral }}</td>
                                <td>{{ $pic->nomor_telepon }}</td>
                                <td>
                                    <?php $namaPIC = $pic->nama_pic; ?>
                                    <?php $id = $pic->id; ?>
                                    <a href="/pic-show/{{ $pic->id }}" class="text-decoration-none btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="/pic-update/{{ $pic->id }}" class="text-decoration-none btn btn-warning"><i class="fas fa-pen-to-square"></i></a>
                                    <button class="btn btn-danger text-dark" onclick="confirmation('{{ $namaPIC }}', '{{ $id }}')"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">
                    {{ $dataPIC->links('vendor.pagination.bootstrap-5') }}
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
    var del=confirm(`Anda yakin ingin menghapus data pic bernama ${namaSekolah} ?`);
    if (del==true){
        window.location.href=`/pic-delete/${delId}`;
    }
    return del;
    }
</script>
@endpush