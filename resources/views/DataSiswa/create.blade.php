@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Daftar Siswa</h1>
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
                    Form Tambah Siswa Baru
                </p>
            </div>
            <!-- <div class="card-body">
                <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
            </div> -->
            <form action="/data-siswa/create/student" method="post">
                @csrf
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-lg-3 mx-4">
                        <label for="ktp" class="col-form-label">KTP</label>
                        <input type="number" name="ktp" id="ktp" class="form-control @error('ktp') is-invalid @enderror" value="{{ old('ktp') }}" autocomplete="off" autofocus required>
                        @error('ktp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <p id="karakter" class="form-text" style="margin-top: 2px;" hidden><span data-feather="alert-circle" class="align-text-bottom"></span></p>

                        <label for="nama_siswa" class="col-form-label">NAMA</label>
                        <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}" required>
                        @error('nama_siswa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div id="nama" hidden></div>


                        <label for="email" class="col-form-label">EMAIL</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div id="alamatemail"></div>

                        <label for="tanggal_lahir" class="col-form-label">TANGGAL LAHIR</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" max="{{ $date }}" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <input type="hidden" name="nomor_pendaftaran" class="@error('nomor_pendaftaran') is-invalid @enderror form-control" id="nomor_pendaftaran" placeholder="nomor_pendaftaran" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $nomor }}"  required>
                        <input type="hidden" name="tahun_daftar" class="@error('tahun_daftar') is-invalid @enderror form-control" id="tahun_daftar" placeholder="tahun_daftar" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $year }}"  required>
                        <input type="hidden" name="password" class="@error('password') is-invalid @enderror form-control" id="password" placeholder="password" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $nomor }}"  required>
                        <input type="hidden" name="status" class="@error('status') is-invalid @enderror form-control" id="status" placeholder="status" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="diterima"  required>
                    </div>
                    <div class="col-lg-3 mt-2">
                        <label for="pic_id">PIC</label>
                        <select name="pic_id" class="form-select mt-1 text-bg-primary" id="pic_id">
                            <option value="">Pilih PIC</option>
                            @foreach( $pic as $leader )
                                <option value="{{ $leader->id }}">{{ $leader->nama_pic }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-end mx-3 mt-3">
                    <div class="col-6 p-2 d-flex justify-content-center align-items-end">
                        <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa-solid fa-database mx-2"></i>Tambah Siswa</button>
                        <a href="/data-siswa" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


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

    let ktp = document.getElementById('ktp');
    let ktpubah = document.getElementById('karakter');
    function sisaKarakter(){
        let valueInput = ktp.value;
        let panjangInputan = valueInput.length;
        if( panjangInputan <= 16 ){

            let valueMax = '16';
            let sisa = valueMax-panjangInputan;
            let kalimatSisa = 'Sisa karakter : ' + sisa;
            ktpubah.removeAttribute('hidden');
            ktpubah.innerText = kalimatSisa;
            ktpubah.style.marginTop = '5px';
            ktp.value = valueInput;
        }else{

            let split = valueInput.split('');
            split = split.splice(0,16);
            split = split.join("");
            console.log(split);
            ktp.value = split;
        }
        
    }
    
    ktp.addEventListener('keyup', sisaKarakter);
    ktp.addEventListener('blur', function(){
        ktpubah.setAttribute('hidden', '');
    });


    
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