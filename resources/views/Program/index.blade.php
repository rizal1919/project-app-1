@extends('layouts.main')

@section('content')
<div class="container-lg mt-2 mx-5" >
    <div class="row">
        <div class="col-lg-3" style="margin-left: 60px;">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Program</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Short Course</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10 text-end">
        <button class="btn btn-primary">
            <a href="/create" class="text-decoration-none text-light"> Tambah Program</a>
        </button>
    </div>
</div>
<div class="row justify-content-center my-3">
    <div class="col-10">
    @if( session('update') )
    <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
        <strong>{{ session('update') }}</strong> Program telah berhasil diubah.
        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if( session('destroy') )
    <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
        <strong>{{ session('destroy') }}</strong> Program telah berhasil dihapus.
        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if( session('create') )
    <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
        <strong>{{ session('create') }}</strong> Program telah berhasil ditambahkan.
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
                        <th colspan="2">Program</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach( $programs as $program)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $program->nama_program }}</td>
                        <td>
                            <button class="btn btn-primary"><a href="" class="text-decoration-none" style="color: white;">Tambah Materi</a></button>
                        </td>
                        <td>
                            <a href="/show/{{ $program->id }}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                            <a href="/update/{{ $program->id }}" class="btn btn-primary"><i class="fas fa-pen-to-square"></i></a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-trash"></i>
                            </button>
                            <!-- <button type="button" id="delete" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fas fa-trash"></i>
                            </button> -->
                            <!-- Button trigger modal -->
                        </td>
                    </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
        

@endsection
<!-- @push('modal')
    @foreach($programs as $program)
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/delete/{{ $program->id }}" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-trash mx-2"></i>Hapus Program
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('delete')
                    <p>Anda yakin ingin menghapus program ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus !</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
@endpush -->
@push('modal')


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="/delete/{{ $program->id }}" method="post">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash mx-2"></i>Hapus Program</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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
@endpush

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
@endpush
