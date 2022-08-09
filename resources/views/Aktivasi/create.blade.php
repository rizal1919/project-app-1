@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
    <div class="container d-flex justify-content-center my-4">
        <div class="card col-12 justify-content-center">
            @if( session('pendaftaranGagal') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Informasi data <strong>{{ session('pendaftaranGagal') }}</strong> paket pilihan harus dipilih.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('sukses') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi data <strong>{{ session('sukses') }}</strong> telah teraktivasi.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    Form Aktivasi
                </p>
            </div>
            
            <form action="/create-aktivasi" method="post">
                @csrf
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-auto mx-5">
                        <label for="nama_aktivasi" class="col-form-label">Nama Aktivasi</label>
                        <input type="text" autocomplete="off" name="nama_aktivasi" id="nama_aktivasi" class="form-control @error('nama_aktivasi') is-invalid @enderror" value="{{ old('nama_aktivasi') }}">
                        @error('nama_aktivasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div id="nama"></div>

                        <label for="harga" class="col-form-label">Harga</label>
                        <input type="text" autocomplete="off" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}">
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="noktp"></div>

                        <label for="periode" class="col-form-label">Periode</label>
                        <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" value="{{ old('periode') }}">
                        @error('periode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        
                    </div>
                    <div class="col-auto">
                        
                        <label for="program" class="col-form-label">Nama Program</label>
                        <input type="text" name="program" id="program" class="form-control @error('program') is-invalid @enderror" value="{{ old('program') }}">
                        @error('program')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <label for="status" class="col-form-label">Status</label>
                        <select class="form-select bg-primary text-light " name="status" id="status">
                            <option value="0">Pilih status aktivasi</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>

                    </div>
                    
                </div>
                <div class="row d-flex justify-content-end mx-3 mt-3">
                    <div class="col-6 p-2 d-flex justify-content-center align-items-end">
                        <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa-solid fa-arrow-up-right-from-square mx-1"></i>Submit Data</button>
                        <a href="/aktivasi" class="btn btn-primary"><span data-feather="arrow-left"></span> Kembali</a>
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