@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
    <div class="container d-flex justify-content-center my-3">
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
            <form action="/form-registrasi/create" method="post">
                @csrf

                <div class="row g-4 my-3 d-flex justify-content-center">
                    <div class="col-sm-7">
                        <div class="row my-3 d-flex justify-content-center text-end">
                            <label for="nama_siswa" class="col-sm-5 col-form-label col-form-label-sm fw-bold">Nama Siswa</label>
                            <div class="col-sm-7 text-start">
                                <select name="nama_siswa" id="nama_siswa" class="form-select form-select-sm">
                                    <option selected disabled>Pilih Siswa ...</option>
                                    @foreach( $students as $student )
                                        <option value="{{ $student->id }}">{{ $student->nama_siswa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row my-3 d-flex justify-content-center text-end">
                            <label for="ktp" class="col-sm-5 col-form-label col-form-label-sm fw-bold">KTP (Kartu Tanda Penduduk)</label>
                            <div class="col-sm-7">
                                <input type="number" name="ktp" readonly placeholder="KTP" class="form-control form-control-sm" id="ktp" value="{{ old('ktp') }}">
                            </div>
                        </div>
                        <div class="row my-3 d-flex justify-content-center text-end">
                            <label for="email" class="col-sm-5 col-form-label col-form-label-sm fw-bold">Email</label>
                            <div class="col-sm-7">
                                <input type="text" name="email" readonly placeholder="example@gmail.com" class="form-control form-control-sm" id="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="row my-3 d-flex justify-content-center text-end">
                            <label for="tanggal_lahir" class="col-sm-5 col-form-label col-form-label-sm fw-bold">Tanggal Lahir</label>
                            <div class="col-sm-7">
                                <input type="date" name="tanggal_lahir" readonly class="form-control form-control-sm" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>

                        <!-- hati2 disini ada id hidden yang juga diambil -->
                        <input type="number" name="id" id="id" hidden>
                        <!-- --------------------------------------- -->

                        <div class="row my-3 d-flex justify-content-center text-end">
                            <label for="aktivasi_id" class="col-sm-5 col-form-label col-form-label-sm fw-bold">Paket Aktivasi</label>
                            <div class="col-sm-7">
                                <select name="aktivasi_id" id="aktivasi_id" class="form-select form-select-sm">
                                    <option selected disabled>Pilih Aktivasi ...</option>
                                    @foreach( $aktivasis as $aktivasi )
                                    <option value="{{ $aktivasi->id }}">{{ $aktivasi->nama_aktivasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 mb-4 d-flex justify-content-center text-end">
                            <label for="metode_pembayaran" class="col-sm-5 col-form-label col-form-label-sm fw-bold">Metode Pembayaran</label>
                            <div class="col-sm-7">
                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select form-select-sm">
                                    <option selected disabled>Pilih Metode Pembayaran ...</option>
                                    <option value="1">Tunai</option>
                                    <option value="2">Cicilan 2x</option>
                                    <option value="3">Cicilan 3x</option>
                                    <option value="5">Cicilan 5x</option>
                                    <option value="6">Cicilan 6x</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 p-3">
                        <div class="card">
                            <div class="card-header">
                                <p class="card-title">Total Pembayaran</p>
                            </div>
                            <div class="card-body" id="total_pembayaran">
                                
                            </div>
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
    <div class="container">
        <div class="card col-lg-12 d-flex justify-content-center">
            <div class="card-header">
                <p class="card-title">Rincian Tagihan</p>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tagihan</th>
                            <th>Total Tagihan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="data-detail">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function(){

        $( '#nama_siswa' ).select2( {
            theme: "bootstrap-5",
            placeholder: 'Pilih Siswa',
        });
        
        $('#metode_pembayaran').on('change', function(){
            let metode = $(this).val();
            let aktivasi_id = $('#aktivasi_id').val();
            
            $.ajax({
                url:"{{ route('getPayment') }}",
                type:"GET",
                data:{
                    'metode':metode,
                    'aktivasi_id':aktivasi_id
                },
                success:function(data){
                    
                    console.log(data.table);
                    console.log(data.boxDetail);

                    $('#total_pembayaran').html(data.boxDetail);
                    $('#data-detail').html(data.table);
                }
            });
        });
        

        $('#nama_siswa').on('select2:select', function (e) {
            var data = e.params.data;
            let test = $('#nama_siswa').select2('data');
          
            $.ajax({
                url:"{{ route('getStudent') }}",
                type:"GET",
                data:{'nama_siswa':data.text},
                success:function(data){

                    console.log(data);

                    let ktpSiswaDicari = '';
                    console.log(data.length);
                    if(data.length >= 2){
                        console.log(data);
                        ktpSiswaDicari = prompt('Ada lebih 1 siswa bernama ' + data[0]['nama_siswa'] + '. Silahkan masukkan KTP untuk menentukan siswa yang ingin dicari!');
                    }else{

                        console.log(data);
                        
                        $('#email').val(data[0]['email']);
                        $('#ktp').val(data[0]['ktp']);
                        $('#tanggal_lahir').val(data[0]['tanggal_lahir']);
                        $('#id').val(data[0]['id']);
                    }

                    let i = 0;
                    for( const siswa of data ){

                        if( siswa.ktp === ktpSiswaDicari ){
                            $('#ktp').val(data[i]['ktp']);
                            $('#email').val(data[i]['email']);
                            $('#tanggal_lahir').val(data[i]['tanggal_lahir']);
                            $('#id').val(data[i]['id']);
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