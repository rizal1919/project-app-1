@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
    <div class="container d-flex justify-content-center my-4">
        <div class="card col-12 justify-content-center">
            @if( session('pendaftaranGagal') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('pendaftaranGagal') }}</strong> paket pilihan harus dipilih.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('pendaftaranBerhasil') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('pendaftaranBerhasil') }}</strong> adalah kode untuk aktivasi program.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    Form Registrasi
                </p>
            </div>
            <div class="card-body">
                <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
            </div>
            <form action="/form-registrasi/reguler-create" method="post">
                @csrf
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-auto mx-5">
                        <label for="ktp" class="col-form-label">KTP</label>
                        <input type="text" autocomplete="off" name="ktp" id="ktp" class="form-control @error('ktp') is-invalid @enderror" value="{{ old('ktp') }}" placeholder="nomor ktp">
                        @error('ktp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="noktp"></div>

                        <label for="nama_siswa" class="col-form-label">NAMA</label>
                        <input type="text" autocomplete="off" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}"  placeholder="nama">
                        @error('nama_siswa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div id="nama"></div>


                        <label for="email" class="col-form-label">EMAIL</label>
                        <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"  placeholder="example@gmail.com">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div id="alamatemail"></div>

                        <label for="tanggal_lahir" class="col-form-label">TANGGAL LAHIR</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" max="{{ $date }}" value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                    <div class="col-auto">
                        
                        <label for="kurikulum_id" class="col-form-label">PILIHAN PAKET REGULER</label>
                        <div class="col-auto"> 
                            <select name="kurikulum_id" id="kurikulum_id" class="p-1 bg-primary text-center text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">

                                <option value="0">Tidak memilih paket</option>
                                @foreach( $kurikulums as $kurikulum )
                                <option value="{{ $kurikulum['id'] }}">{{ $kurikulum['nama_kurikulum'] }}</option>
                                @endforeach
                            
                            </select>
                        </div>

                    </div>
                    <!-- <div class="col-auto">
                        
                        <label for="kurikulum_id" class="col-form-label">PILIHAN PAKET AKTIVASI</label>
                        <div class="col-auto"> 
                            <select name="kurikulum_id" id="kurikulum_id" class="p-1 bg-primary text-center text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">

                                <option value="0">Tidak memilih paket</option>
                                
                                <option value=""></option>
                               
                            </select>
                        </div>

                    </div> -->
                </div>
                <div class="row d-flex justify-content-end mx-3 mt-3">
                    <div class="col-10 p-2 d-flex justify-content-center align-items-end">
                        <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa-solid fa-arrow-up-right-from-square mx-1"></i>Submit Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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