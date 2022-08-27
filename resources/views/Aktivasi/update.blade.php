@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
    <div class="container d-flex justify-content-center my-4">
        <div class="card col-12 justify-content-center">
            @if( session('gagal') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Informasi <strong>{{ session('gagal') }}</strong> status harus ditentukan.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('sukses') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi <strong>{{ session('sukses') }}</strong> program teraktivasi telah diubah.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    Form Aktivasi
                </p>
            </div>
            
            <form action="/update-aktivasi-program/{{ $aktivasi->id }}" method="post">
                @csrf
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-auto mx-5">
                        <input type="hidden" name="id" value="{{ $aktivasi->id }}">
                        <label for="nama_aktivasi" class="col-form-label">Nama Aktivasi</label>
                        <input type="text" autocomplete="off" name="nama_aktivasi" id="nama_aktivasi" class="form-control @error('nama_aktivasi') is-invalid @enderror" value="{{ old('nama_aktivasi', $aktivasi->nama_aktivasi) }}">
                        @error('nama_aktivasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div id="nama"></div>

                        <label for="biaya" class="col-form-label">Biaya</label>
                        <input type="number" autocomplete="off" name="biaya" id="biaya" class="form-control @error('biaya') is-invalid @enderror" value="{{ old('biaya', $aktivasi->biaya) }}">
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="noktp"></div>

                        <label for="periode" class="col-form-label">Periode</label>
                        <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" value="{{ old('periode', $aktivasi->periode) }}">
                        @error('periode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        
                    </div>
                    <div class="col-auto">
                        
                        <label for="program_id" class="col-form-label">Nama Program</label>
                        <select class="form-select bg-primary text-light " name="program_id" id="program_id">
                            <option value="0">Pilih Program</option>
                            @foreach( $programs as $program )
                                @if( $program->id == $aktivasi->program_id )
                                    <option value="{{ $program->id }}" selected>{{ $program->nama_program }}</option>
                                @else
                                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                @endif
                            @endforeach
                        </select>

                        <label for="status" class="col-form-label">Status</label>
                        <select class="form-select bg-primary text-light " name="status" id="status">
                            @if( $aktivasi->status === 'Aktif' )
                                <option value="0">Pilih status aktivasi</option>
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            @else
                                <option value="0">Pilih status aktivasi</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif" selected>Tidak Aktif</option>
                            @endif
                        </select>

                    </div>
                    
                </div>
                <div class="row d-flex justify-content-end mx-3 mt-3">
                    <div class="col-6 p-2 d-flex justify-content-center align-items-end">
                        <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa-solid fa-arrow-up-right-from-square mx-2"></i>Ubah Data Aktivasi</button>
                        <a href="/aktivasi" class="btn btn-primary"><span data-feather="arrow-left"></span> Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection


@push('js')
<!-- <script>
    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('tanpa-rupiah');
    tanpa_rupiah.addEventListener('keyup', function(e)
    {
        tanpa_rupiah.value = formatRupiah(this.value);
    });
    
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('dengan-rupiah');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
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