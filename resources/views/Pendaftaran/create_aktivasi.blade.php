@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
    <div class="container d-flex justify-content-center my-4">
        <div class="card col-12 justify-content-center">
            @if( session('pendaftaranGagal') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Pilihan aktivasi siswa <strong>{{ session('pendaftaranGagal') }}</strong> harus ditentukan.
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
                    Form Registrasi Short Course
                </p>
            </div>
            <form action="/form-registrasi/aktivasi-create" method="post">
                @csrf
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-auto mx-5">
                        
                        <label for="nama_siswa" class="col-form-label">NAMA</label>
                        <select class="form-select" name="nama_siswa" id="single-select-field" style="width: 100%;" data-placeholder="Pilih Siswa">
                            <option value=""></option>
                            @foreach( $students as $student )
                                <option>{{ $student->nama_siswa }}</option>
                            @endforeach
                        </select>
                            
                        <label for="ktp" class="col-form-label">KTP</label>
                        <input type="text" autocomplete="off" name="ktp" id="ktp"  class="form-control @error('ktp') is-invalid @enderror" value="{{ old('ktp') }}" placeholder="nomor ktp">
                        @error('ktp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="noktp"></div>

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
                        
                        <label for="aktivasi_id" class="col-form-label">PILIHAN PAKET AKTIVASI</label>
                        <div class="col-auto"> 
                            <select name="aktivasi_id" id="aktivasi_id" class="p-1 bg-primary text-center text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">

                                <option value="0">Tidak memilih paket</option>
                                @foreach( $aktivasis as $aktivasi )
                                <option value="{{ $aktivasi['id'] }}">{{ $aktivasi['nama_aktivasi'] }}</option>
                                @endforeach
                            
                            </select>
                        </div>

                    </div>
                </div>
                <div class="row d-flex justify-content-end mx-3 mt-3">
                    <div class="col-7 p-2 d-flex justify-content-center align-items-end">
                        <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol mendaftar.</small></em></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa-solid fa-database mx-2"></i>Mendaftar</button>
                        <a href="/form-registrasi" class="btn btn-primary">Kembali</a>
                    </div>
                    
                </div>
            </form>

        </div>
    </div>

<script>
    $(document).ready(function(){

        $( '#single-select-field' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-70' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        });

        $('#single-select-field').on('select2:select', function (e) {
            var data = e.params.data;
            // console.log(data.text);
            
            let test = $('#single-select-field').select2('data');
            console.log(test);
    
            
            $.ajax({
                url:"{{ route('search') }}",
                type:"GET",
                data:{'name':data.text},
                success:function(data){

                    let ktpSiswaDicari = '';
                    console.log(data.length);
                    if(data.length >= 2){
                        ktpSiswaDicari = prompt('Ada lebih 1 siswa bernama ' + data[0]['nama_siswa'] + '. Silahkan masukkan KTP untuk menentukan siswa yang ingin dicari!');
                    }else{
                        
                        $('#email').val(data[0]['email']);
                        $('#ktp').val(data[0]['ktp']);
                        $('#tanggal_lahir').val(data[0]['tanggal_lahir']);
                    }

                    let i = 0;
                    for( const siswa of data ){

                        if( siswa.ktp === ktpSiswaDicari ){
                            $('#email').val(data[i]['email']);
                            $('#ktp').val(data[i]['ktp']);
                            $('#tanggal_lahir').val(data[i]['tanggal_lahir']);
                        }
                        i++;
                    }

                    
                }
            });
            
        });
    
        // $('#nama_siswa').on('keyup', function(){
        //     var value = $(this).val();
        //     $.ajax({
        //         url:"{{ route('search') }}",
        //         type:"GET",
        //         data:{'nama_siswa':value},
        //         success:function(data){

        //             $('#nama').html(data);                    
                    
        //         }
        //     });
        // });


        // $(document).on('click', '#n', function(){
        //     var value = $(this).text();
        //     $("#nama_siswa").val(value);
        //     $('#nama').html('');
        // });

        // $('#ktp').on('keyup', function(){
        //     var value = $(this).val();
        //     $.ajax({
        //         url:"{{ route('ktp') }}",
        //         type:"GET",
        //         data:{'ktp':value},
        //         success:function(data){

                    
        //             console.log(data);
        //             console.log( data[0]['nama_siswa'] );

        //             $('#noktp').html(data);
        //             $('#nama_siswa').val(data[0]['nama_siswa']);
        //             $('#email').val(data[0]['email']);
        //             $('#tanggal_lahir').val(data[0]['tanggal_lahir']);
                    
        //         }
        //     });
        // });


        // $(document).on('click', '#k', function(){
        //     var value = $(this).text();
        //     $("#ktp").val(value);
        //     $('#noktp').html('');
        // });

        // $('#email').on('keyup', function(){
        //     var value = $(this).val();
        //     $.ajax({
        //         url:"{{ route('email') }}",
        //         type:"GET",
        //         data:{'email':value},
        //         success:function(data){

        //             $('#alamatemail').html(data);
                    
        //         }
        //     });
        // });


        // $(document).on('click', '#e', function(){
        //     var value = $(this).text();
        //     $("#email").val(value);
        //     $('#alamatemail').html('');
        // });



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