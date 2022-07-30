@extends('Layouts.main')

@include('Layouts/Navbar/navbar')
@section('content')
<div class="container-lg mt-2 mx-5" >
    <div class="row">
        <div class="col-lg-3" style="margin-left: 60px;">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-address-card mx-2"></i>Program</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $dataProgram->nama_program }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10 text-end">
        <form action="/materi/{{ $dataProgram->id }}" method="get" class="d-inline">
            @csrf
            <input type="text" id="search" name="search" class="form-control d-inline" style="width: 20%;" placeholder="Search">
            <button class="btn btn-primary" id="basic-addon2">Go!</button>
        </form>
        <button class="btn btn-primary">
            <a href="/create-materi/{{ $dataProgram->id }}" class="text-decoration-none text-light"><i class="fa-solid fa-plus"></i>Tambah Materi</a>
        </button>
        <button class="btn btn-primary">
            <a href="/program" class="text-decoration-none text-light"> Kembali</a>
        </button>
    </div>
</div>
<div class="row justify-content-center my-3">
    <div class="col-10">
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
    <div class="col-10">
        <div class="card">
        <table class="table table-light table-striped table-hover m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Materi | Program ID</th>
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
                        <td>{{ $materis->nama_materi }} | {{ $materis->program_id }}</td>
                        <td>{{ $materis->jumlah_pertemuan }}</td>
                        <td>{{ $materis->menit }}</td>
                        <td>
                            <a href="/show-materi/{{ $materis->id }}" class="btn btn-info text-decoration-none text-dark"><i class="fas fa-eye"></i></a>
                            <a href="/update-materi/{{ $materis->id }}" class="btn btn-warning text-decoration-none text-dark"><i class="fas fa-pen-to-square"></i></a>
                            <!-- <button type="button" class="btn btn-danger deteleCategoryBtn" data-bs-toggle="modal" value="{{ $materis->id }}"  data-bs-target="#exampleModal" data-url="#">
                            <i class="fas fa-trash"></i>
                            </button> -->

                            <!-- <a href="/delete-materi/" class="btn btn-danger delete deleteCategoryBtn" data-bs-toggle="modal" value="4" data-bs-target="#exampleModal" data-url="/delete-materi/{{ $materis->id }}"><i class="fas fa-trash"></i></a> -->

                            <!-- <button type="button" class="btn btn-danger deleteCategoryBtn" data-bs-toggle="modal" value="{{ $materis->id }}" data-bs-target="#exampleModal">
                            <i class="fas fa-trash"></i>
                            </button> -->
                            <button class="btn btn-danger text-dark" onclick="confirmation('{{ $materis->id }}')"><i class="fas fa-trash"></i></button>
                        
                            <!-- <a href="/delete-materi/{{ $materis->id }}" class="btn btn-primay text-decoration-none" data-bs-toggle="modal" onclick="deleteModal()"  data-bs-target="#exampleModal"><i class="fas fa-trash"></i></a> -->
                            <!-- <a href="/delete-materi/{{ $materis->id }}" class="btn btn-danger text-decoration-none text-dark" onclick="confirm('Anda yakin?')"><i class="fas fa-trash"></i></a> -->
                            
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
