@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
<div class="container-lg mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
        <div class="card p-3">
            <div class="card-header mb-1 rounded text-center">
                <h4 class="card-title">DATA PENDAFTAR SC ACADEMY</h4>
            </div>
            <div class="card-body">
                    @if( session('destroy') )
                    <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                        <strong>{{ session('destroy') }}</strong> Data siswa pendaftar telah berhasil dihapus.
                        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if( session('pendaftaranBerhasil') )
                    <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                        Siswa atas nama <strong>{{ session('pendaftaranBerhasil') }}</strong> berhasil terdaftar dalam program.
                        <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 d-flex mt-4 justify-content-start">
                        <a href="/form-registrasi/reguler" class="btn btn-primary mx-1" style="width: 20%; height: 100%;">Tambah Siswa</a>
                        
                        <form action="/form-registrasi" method="get" class="mx-2" style="width: 80%;" >
                            @csrf
                            <div class="input-group">
                                <input type="text" name="nama_siswa" value="" class="form-control text-end" placeholder="Nama">
                                <input type="text" name="nama_program" value="" class="form-control text-end" placeholder="Kelas">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
                        
                        <!-- <a href="/dashboard" style="width: 10%; height: 100%;" class="btn btn-primary text-decoration-none text-light self-align-center">Kembali </a> -->
                        
                    </div>
                </div>
                
            </div>
            <div class="card-body">
                <div class="card p-3">
                    <table class="table table-light table-hover table-striped" style="border-radius: 5px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                
                        @foreach( $dataSiswaReguler as $dasis )
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dasis['nama_siswa'] }}</td>
                                    <td>{{ $dasis['nama_program'] }}</td>
                                    <td>
                                        <?php $id = $dasis['id']; ?>
                                        <!-- <a href="/data-siswa/show/student/" class="btn btn-info text-decoration-none text-dark"><i class="fas fa-eye"></i></a> -->
                                        <!-- <a href="/data-siswa/update/student/" class="btn btn-warning text-decoration-none text-dark"><i class="fas fa-pen-to-square"></i></a> -->
                                        <button class="btn btn-danger text-dark border-0" onclick="confirmation('{{ $id }}')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                  
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 d-flex justify-content-center">
                    {{ $dataSiswaReguler->links() }}
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
    function confirmation(delName){
    var del=confirm(`Anda yakin ingin menghapus program dengan id ${delName} ?`);
    if (del==true){
        window.location.href=`/form-registrasi-delete/${delName}`;
    }
    return del;
    }
</script>
<script>
    $(document).ready(function(){
    
        
        $('#nama_siswa').on('keyup', function(){
            var value = $(this).val();
            $.ajax({
                url:"{{ route('search') }}",
                type:"GET",
                data:{'nama_siswa':value},
                success:function(data){

                    

                    $('#nama').html(data);
                    
                    
                    
                }
            });
        });


        $(document).on('click', '#n', function(){
            var value = $(this).text();
            $("#nama_siswa").val(value);
            $('#nama').html('');
        });

        $('#ktp').on('keyup', function(){
            var value = $(this).val();
            $.ajax({
                url:"{{ route('ktp') }}",
                type:"GET",
                data:{'ktp':value},
                success:function(data){

                    
                    console.log(data);
                    console.log( data[0]['nama_siswa'] );

                    $('#noktp').html(data);
                    $('#nama_siswa').val(data[0]['nama_siswa']);
                    $('#email').val(data[0]['email']);
                    $('#tanggal_lahir').val(data[0]['tanggal_lahir']);
                    
                }
            });
        });


        $(document).on('click', '#k', function(){
            var value = $(this).text();
            $("#ktp").val(value);
            $('#noktp').html('');
        });

        $('#email').on('keyup', function(){
            var value = $(this).val();
            $.ajax({
                url:"{{ route('email') }}",
                type:"GET",
                data:{'email':value},
                success:function(data){

                    $('#alamatemail').html(data);
                    
                }
            });
        });


        $(document).on('click', '#e', function(){
            var value = $(this).text();
            $("#email").val(value);
            $('#alamatemail').html('');
        });



    });
</script>
@endsection


@push('js')
<!-- <script>
    const num = 0;
function Function() {

    const num = 0;
    document.getElementById("demo").innerHTML = num;

    num++;
}
</script> -->
<script>
    function changeStyle(){
        var element = document.getElementById("hide");
        element.style.display = "none";
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