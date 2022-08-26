@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-5" >
    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-lg-12 d-flex justify-content-center align-items-center mt-2">
            <div class="card" style="width: 100%;">
                <div class="card-header">
                    <h4 class="card-text"><i class="fa-solid fa-address-card mx-2"></i>Daftar Program Aktivasi</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">Program List</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center mb-3">
        <div class="col-11 text-end">
            
            <a href="/create-aktivasi" class="btn btn-primary text-decoration-none text-light"><i class="fa-solid fa-plus mx-1"></i> Program Aktivasi</a>
            <form action="/aktivasi" method="get" class="d-inline">
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
            Informasi aktivasi <strong>{{ session('destroy') }}</strong> telah berhasil dihapus.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('destroyFailed') )
        <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
            Informasi aktivasi <strong>{{ session('destroyFailed') }}</strong> tidak bisa terhapus, silahkan hapus siswa yang terdaftar terlebih dahulu.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('destroyFailedAssignment') )
        <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
            Informasi aktivasi <strong>{{ session('destroyFailedAssignment') }}</strong> tidak bisa terhapus, silahkan hapus pada halaman penugasan.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('create') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            Aktivasi program <strong>{{ session('create') }}</strong> telah berhasil ditambahkan.
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
                        <th >Nama Aktivasi</th>
                        <th>Program</th>
                        <th>Harga</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach( $aktivasi as $aktif )
                    <tr>
                        
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $aktif->nama_aktivasi }}</td>
                        <td>{{ $aktif->program->nama_program }}</td>
                        <td>{{ $aktif->harga }}</td>
                        <td>{{ $aktif->periode }}</td>
                        <td><p class="badge bg-primary text-light">{{ $aktif->status }}</p></td>
                        <td>
                                <a href="/show-aktivasi-program/{{ $aktif->id }}" class="btn btn-info text-dark"><i class="fas fa-eye"></i></a>
                                <a href="/update-aktivasi-program/{{ $aktif->id }}" class="btn btn-warning text-dark"><i class="fas fa-pen-to-square"></i></a>
                                <button type="button" id="delete" data-url="/delete-aktivasi-program/" style="margin-right: 50px;" class="btn btn-danger text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="confirmation('{{ $aktif->id }}', '{{ $aktif->nama_aktivasi }}')"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        <div class="card-body mt-2 mb-5"> 
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

    function confirmation(delId, namaAktivasi){

        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + delId;
        // output = delete-materi/1

        $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus aktivasi berjudul ' + '<strong>' + namaAktivasi +  '</strong>' + ' ? </p>';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
</script>
<script>

    function left(id){

        let element = document.getElementById('tombol');
        var x = element.getAttribute('href');
        // alert(x);
        
        // let kal = document.getElementById('kalimat');
        // var y = kal.getAttribute('value');
        // alert(y);

        var tes = x.split("");
        let length = tes.length;
        let citrus = tes.slice(1, length);
        let coba = citrus.join("");
        let angka = parseInt(coba);

        // const name = "hello, world!";
        // document.querySelector(`[data-name=${CSS.escape(name)}]`);
        // document.querySelector(`[data-id-type=${CSS.escape(angka)}]`);

        if( angka >= 0 && angka < id ){
            angka++;
            document.getElementById("tombol").href = "#" + angka;

            document.querySelector(`[data-id-type=${CSS.escape(angka)}]`).style.display = "inline";
            
                // document.getElementById("kalimat").style.display = "inline"; 
            
            
        }


    }

    function right(id){

    let element = document.getElementById('tombols');
    var x = element.getAttribute('href');
    

    var tes = x.split("");
    let length = tes.length;
    let citrus = tes.slice(1, length);
    let coba = citrus.join("");
    let angka = parseInt(coba);
    // let hasil = Number(angka)-1;
    
    document.getElementById("tombol").href = "#" + angka;
    

    }


    function details(id){

        
        let element = document.getElementById('pencet');
        var x = element.getAttribute('value');
        // alert(x);        

        
        
        if( x == 1 ){
            x=0;
            document.querySelector(`[data-icon-type=${CSS.escape(id)}]`).setAttribute('class', 'fa-solid fa-arrow-down mx-3');
            document.querySelector(`[data-id-type=${CSS.escape(id)}]`).style.display = "inline";
            document.getElementById('pencet').value=x;
        }else{
            x=1;
            document.querySelector(`[data-icon-type=${CSS.escape(id)}]`).setAttribute('class', 'fa-solid fa-arrow-right mx-3');
            document.querySelector(`[data-id-type=${CSS.escape(id)}]`).style.display = "none";
            document.getElementById('pencet').value=x;
            // alert(x);
        }

    }
</script>
@endpush