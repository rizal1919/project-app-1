@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
    <div class="container d-flex justify-content-center my-4">
        <div class="card col-12 justify-content-center">
            @if( session('teacher') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Informasi <strong>{{ session('teacher') }}</strong> pilihan harus dipilih.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('aktivasi') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Informasi <strong>{{ session('aktivasi') }}</strong> pilihan harus dipilih.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('materi') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Informasi <strong>{{ session('materi') }}</strong> pilihan harus dipilih.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('create') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('create') }}</strong> Informasi data telah tersimpan
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    Form Assign Guru
                </p>
            </div>
            <form action="/assign-teacher-create" method="post">
                @csrf
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-lg-3 mx-5">

                        <label for="teacher_id" class="col-form-label">GURU</label>
                        <div class="col-auto"> 
                            <select name="teacher_id" id="teacher_id" class="form-select">

                                <option>Pilih Guru ...</option>
                                @foreach( $teachers as $teacher )
                                    <option value="{{ $teacher['id'] }}">{{ $teacher['teacher_name'] }}</option>
                                @endforeach
                            
                            </select>
                        </div>

                        <label for="paket" class="col-form-label">PAKET</label>
                        <div class="col-auto"> 
                            <select name="paket" id="paket" class="form-select">

                                <option>Pilih Paket ...</option>
                                <?php $i = 0; ?>
                                <?php $j = 0; ?>
                                @foreach( $pakets as $paket )
                                    @if( $paket['tipePaket'] == "Aktivasi" )

                                        <?php if( $i === 0 ): ?>
                                            <optgroup label="{{ $paket['tipePaket'] }}">
                                            <option value="{{ $paket['namaProgram'] }}">{{ $paket['namaProgram'] }}</option>
                                            <?php $i = 1; ?>
                                        <?php else: ?>
                                            <option value="{{ $paket['namaProgram'] }}">{{ $paket['namaProgram'] }}</option>
                                        <?php endif; ?>
                                    @else
                                        <?php if( $j === 0 ): ?>
                                            <optgroup label="{{ $paket['tipePaket'] }}">
                                            <option value="{{ $paket['namaProgram'] }}">{{ $paket['namaProgram'] }}</option>
                                            
                                            <?php $j = 1; ?>
                                        <?php else: ?>
                                            <option value="{{ $paket['namaProgram'] }}">{{ $paket['namaProgram'] }}</option>
                                        <?php endif; ?>
                                        
                                    @endif
                                    
                                @endforeach
                            
                            </select>
                        </div>

                        <label for="materi_id" class="col-form-label">MATERI</label>
                        <div class="col-auto"> 
                            <select name="materi_id" id="materi_id" class="form-select">
                                <option disabled>Pilih Materi ...</option>
                            </select>
                        </div>


                    </div>
                    <div class="col-lg-3">
                        <label for="status" class="col-form-label">STATUS</label>
                        <div class="col-auto"> 
                            <select name="status" id="status" class="form-select bg-primary text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">
                                <option value="0">Belum Terlaksana</option>
                                <option value="1">Terlaksana</option>
                            
                            </select>
                        </div>
                        
                        <label for="pertemuan" class="col-form-label">PERTEMUAN</label>
                        <input type="number" name="pertemuan" id="pertemuan" class="form-control @error('pertemuan') is-invalid @enderror" value="{{ old('pertemuan') }}"  placeholder="Pertemuan">
                        @error('pertemuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <label for="tanggal" class="col-form-label">TANGGAL</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>
                <div class="row d-flex justify-content-end mx-3 mt-3">
                    <div class="col-7 p-2 d-flex justify-content-center align-items-end">
                        <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa-solid fa-arrow-up-right-from-square mx-1"></i>Tambah Data</button>
                        <a href="/assign-teacher" class="btn btn-primary">Kembali</a>
                    </div>
                    
                </div>
            </form>

        </div>
    </div>

<script>
    $(document).ready(function(){

        

        $('#paket').on('change', function(){
            var value = $('#paket').val();
            $.ajax({
                url:"{{ route('getmateri') }}",
                type:"GET",
                data:{'nama_paket':value},
                success: function(data){
                    console.log(data);
                    $('#materi_id').html(data);           
                    
                }
            });
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