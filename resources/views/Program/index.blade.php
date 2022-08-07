@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-5" >
    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-lg-12 d-flex justify-content-center align-items-center mt-2">
            <div class="card" style="width: 100%;">
                <div class="card-header">
                    <h4 class="card-text"><i class="fa-solid fa-address-card mx-2"></i>Paket Kurikulum</h4>
                </div>
                <div class="card-body">
                    <h6 class="card-text">{{ $kurikulum->nama_kurikulum }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-11 text-end">
            
            <a href="/create/{{ $kurikulum->id }}" class="btn btn-primary text-decoration-none text-light"><i class="fa-solid fa-plus mx-1"></i>Tambah Program</a>

            <form action="/program/{{ $kurikulum->id }}" method="get" class="d-inline">
                @csrf
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control d-inline" style="width: 20%;" placeholder="Search">
                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
            </form>
            <a href="/kurikulum" class="btn btn-success text-decoration-none text-light">Kembali</a>
        </div>
    </div>
    
</div>
<div class="row justify-content-center my-3">
    <div class="col-11">
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
    <div class="col-lg-11">
        <div class="card p-3">
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
                            <a href="/show-program/{{ $program->id }}" class="btn btn-info text-dark"><i class="fas fa-eye"></i></a>
                            <a href="/update-program/{{ $program->id }}" class="btn btn-warning text-dark"><i class="fas fa-pen-to-square"></i></a>
                            <button class="btn btn-danger text-dark" onclick="confirmation('{{ $program->id }}')"><i class="fas fa-trash"></i></button>
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
<script>
    function confirmation(delName){
    var del=confirm(`Anda yakin ingin menghapus program dengan id ${delName} ?`);
    if (del==true){
        window.location.href=`/delete-program/${delName}`;
    }
    return del;
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


