@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-5" >
    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-lg-12 d-flex justify-content-center align-items-center mt-2">
            <div class="card" style="width: 100%;">
                <div class="card-header">
                    <h4 class="card-text"><i class="fa-solid fa-address-card mx-2"></i>Program</h4>
                </div>
                <div class="card-body">
                    <h6 class="card-text">{{ $dataProgram->nama_program }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-11 text-end">
            <form action="/materi/{{ $dataProgram->id }}" method="get" class="d-inline">
                @csrf
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control d-inline" style="width: 20%;" placeholder="Search">
                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
            </form>
            <a href="/create-materi/{{ $dataProgram->id }}" class="btn btn-primary text-decoration-none text-light"><i class="fa-solid fa-plus mx-1"></i>Tambah Materi</a>
            <a href="/program/{{ $dataProgram->kurikulum_id }}" class="btn btn-success text-decoration-none text-light">Kembali</a>
        </div>
    </div>
</div>
<div class="row justify-content-center my-3">
    <div class="col-11">
        @if( session('update') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('update') }}</strong> Materi telah berhasil diubah.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('destroy') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('destroy') }}</strong> Materi telah berhasil dihapus.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('success') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('success') }}</strong> Materi telah berhasil ditambahkan.
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
                        <th>Materi</th>
                        <th>Jumlah Pertemuan</th>
                        <th>Menit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach( $dataMateri as $materis )
                
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $materis->nama_materi }}</td>
                        <td>{{ $materis->jumlah_pertemuan }}</td>
                        <td>{{ $materis->menit }}</td>
                        <td>
                            <a href="/show-materi/{{ $materis->id }}" class="btn btn-info text-decoration-none text-dark"><i class="fas fa-eye"></i></a>
                            <a href="/update-materi/{{ $materis->id }}" class="btn btn-warning text-decoration-none text-dark"><i class="fas fa-pen-to-square"></i></a>
                            <button class="btn btn-danger text-dark" onclick="confirmation('{{ $materis->id }}')"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body mt-2 mb-5">
            {{ $dataMateri->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>
        

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="#" method="get" id="destroys">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash mx-2"></i>Hapus Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="category_delete_id" id="category_id">
            @csrf
            <p class="card-text">Anda yakin ingin menghapus program ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Ya, Hapus!</button>
            </div>
        </form>
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
</script>
<script>
        const myModal = document.getElementById('modal')
        const myInput = document.getElementById('#staticBackdrop')

        myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
        })
</script>
<script>
    function confirmation(delId){
    var del=confirm(`Anda yakin ingin menghapus materi dengan id ${delId} ?`);
    if (del==true){
        window.location.href=`/delete-materi/${delId}`;
    }
    return del;
    }
</script>
@endpush
