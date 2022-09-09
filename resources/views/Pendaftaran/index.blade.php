@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
        <div class="card p-3">
            <div class="card-header mb-1 rounded text-center">
                <h4 class="card-title">DATA PENDAFTAR SC ACADEMY</h4>
            </div>
            <div class="card-body">
                <div class="row g-1 d-flex justify-content-end my-3">
                    <div class="col-sm-2 text-end">
                        <a href="/form-registrasi/create" class="btn btn-primary mx-1" style="width: 90%;">Pendaftaran</a>
                    </div>
                    <div class="col-sm-10">
                        <form action="/form-registrasi" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="studentName" value="{{ request('studentName') }}" class="form-control text-end" placeholder="Nama">
                                <input type="text" name="activationName" value="{{ request('activationName') }}" class="form-control text-end" placeholder="Kelas">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
                    </div>
                </div>
                @if( session('destroy') )
                <div class="alert alert-warning alert-dismissible fade show" id="hide" role="alert">
                    Informasi siswa <strong>{{ session('destroy') }}</strong> telah dinonaktifkan.
                    <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if( session('restore') )
                <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                    Informasi siswa atas nama <strong>{{ session('restore') }}</strong> berhasil diaktifkan.
                    <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if( session('pendaftaranBerhasil') )
                <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                    Siswa atas nama <strong>{{ session('pendaftaranBerhasil') }}</strong> berhasil terdaftar dalam program.
                    <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="card p-3">
                    <table class="table table-light table-hover table-striped" style="border-radius: 5px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Status Siswa</th>
                                <th>Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $dataSiswa as $siswa )
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $siswa['studentName'] }}</td>
                                    <td>{{ $siswa['activationName'] }}</td>
                                    @if( $siswa['studentStatus'] == 'Graduate')
                                        <td><p class="badge text-bg-primary">{{ $siswa['studentStatus'] }}</p></td>
                                    @else
                                        <td><p class="badge text-bg-success">{{ $siswa['studentStatus'] }}</p></td>
                                    @endif
                                    @if( $siswa['payment'] == 'Lunas')
                                        <td><p class="badge text-bg-primary">{{ $siswa['payment'] }}</p></td>
                                    @else
                                        <td><p class="badge text-bg-warning">{{ $siswa['payment'] }}</p></td>
                                    @endif
                                    <td>
                                        <?php $namaSiswa = $siswa['studentName']; ?>
                                        <?php $studentId = $siswa['idStudent']; ?>
                                        <?php $activationId = $siswa['idActivation']; ?>
                                        <?php $activationName = $siswa['activationName']; ?>
                                        <button type="button" class="btn btn-dark btn-sm" id="delete" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-url="/form-registrasi-softdelete/" onclick="confirmation('{{ $namaSiswa }}', '{{ $studentId }}', '{{ $activationId }}', '{{ $activationName }}')"><i class="fas fa-trash"></i></button>
                                        
                                        <a href="/cost/{{ $studentId }}" class="text-decoration-none btn btn-dark btn-sm">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 d-flex justify-content-center">
                    
                </div>
            </div>
        </div>
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

    function confirmation(namaSiswa, idSiswa, idAktivasi, namaAktivasi){

       
        let url = document.getElementById('delete').getAttribute('data-url');
        let completeUrl = url + idSiswa + '/' + idAktivasi;
        // output = delete-materi/1

        // $('#name').val(delId);
        $('#forms').attr('action', completeUrl);

        let comment = document.getElementById('message');
        comment.innerHTML = '<p> Anda yakin ingin menghapus data siswa <strong>' + namaSiswa + '</strong> dari kelas Aktivasi <strong>' + namaAktivasi + ' ?</strong> </p>';
        

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }
    
</script>
<script>
    function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
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