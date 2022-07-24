@extends('layouts.main')

@section('content')
<div class="container-lg mt-2 mx-5" >
    <div class="row">
        <div class="col-lg-3" style="margin-left: 60px;">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa-solid fa-address-card mx-2"></i>Program</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Short Course</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10 text-end">
        <button class="btn btn-primary">
            <i class="fa-solid fa-plus mx-1"></i><a href="/create" class="text-decoration-none text-light">Tambah Program</a>
        </button>

        <form action="" method="post" class="d-inline">
            @csrf
            <input type="text" id="search" name="search" class="form-control d-inline" style="width: 20%;" placeholder="Search">
            <button class="btn btn-primary" id="basic-addon2">Go!</button>
        </form>
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
                        <th colspan="2">Program | ID</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach( $programs as $program)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $program->nama_program }} | {{ $program->id }}</td>
                        <td>
                        <button class="btn btn-primary"><i class="fa-solid fa-plus mx-1"></i><a href="/materi/{{ $program->id }}" class="text-decoration-none" style="color: white;">Tambah Materi</a></button>
                        </td>
                        <td>
                            <a href="/show/{{ $program->nama_program }}" class="btn btn-info text-dark"><i class="fas fa-eye"></i></a>
                            <a href="/update/{{ $program->id }}" class="btn btn-warning text-dark"><i class="fas fa-pen-to-square"></i></a>
                            <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-trash"></i>
                            </button> -->
                            <!-- <button type="button" id="delete" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fas fa-trash"></i>
                            </button> -->
                            <!-- Button trigger modal -->

                            <a href="/delete/{{ $program->id }}" class="btn btn-danger text-decoration-none text-dark" onclick="confirm('Anda yakin?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body mt-2 mb-5">
            {{ $programs->links('vendor.pagination.bootstrap-5') }}
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
<!-- <script>
    const myModal = document.getElementById('modal')
    const myInput = document.getElementById('#staticBackdrop')

    myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
    })
</script> -->
<!-- <script>
$(document).ready(function(){

    $("#search").keyup(function(){

        var input = $(this).val();
        // alert(input);

        if( input != ""){
            $.ajax({

                url:"/program/" + input,
                method:"POST",
                data:{'search':input},

                success:function(data){
                    $('#Content').html(data);
                }
            })
        }
    });
});
</script> -->
@endpush


