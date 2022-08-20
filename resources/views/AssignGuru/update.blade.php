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
            @if( session('update') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi penugasan guru <strong>{{ session('update') }}</strong> diubah
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    Form Assign Guruku
                </p>
            </div>
            <form action="/assign-teacher-update/3" method="post">
                @csrf
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-auto mx-5">
                        <label for="teacher_id" class="col-form-label">GURU</label>
                        <div class="col-auto"> 
                            <select name="teacher_id" id="teacher_id" class="p-1 bg-primary text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">

                                <option value="0">Tidak memilih guru</option>
                                @foreach( $teachers as $teacher )
                                    @if( $dataguru->teacher_id == $teacher['id'] )
                                        <option value="{{ $teacher['id'] }}" selected>{{ $teacher['teacher_name'] }}</option>
                                    @else
                                        <option value="{{ $teacher['id'] }}">{{ $teacher['teacher_name'] }}</option>
                                    @endif
                                @endforeach
                            
                            </select>
                        </div>

                        <label for="aktivasi_id" class="col-form-label">AKTIVASI</label>
                        <div class="col-auto"> 
                            <select name="aktivasi_id" id="aktivasi_id" class="p-1 bg-primary text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">

                                <option value="0">Tidak memilih aktivasi</option>
                                @foreach( $aktivasis as $aktivasi )
                                    @if( $dataguru->aktivasi_id == $aktivasi['id'] )
                                        <option value="{{ $aktivasi['id'] }}" selected>{{ $aktivasi['nama_aktivasi'] }}</option>
                                    @else
                                        <option value="{{ $aktivasi['id'] }}">{{ $aktivasi['nama_aktivasi'] }}</option>
                                    @endif
                                @endforeach
                            
                            </select>
                        </div>

                        <label for="materi_id" class="col-form-label">MATERI</label>
                        <div class="col-auto"> 
                            <select name="materi_id" id="materi_id" class="p-1 bg-primary text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">
                                
                                <?php for( $i=0; $i<count($programs); $i++ ): ?>
                                    
                                    <!-- ngecek apakah program diikutkan dalam aktivasi -->
                                    @if( count($programs[$i]->aktivasi) === 0 )
                                        <optgroup label="{{ $programs[$i]->nama_program }}">  
                                            @foreach( $materis as $materi )
                                                @if( $materi->program_id == $programs[$i]->id )
                                                    @if( $dataguru['materi_id'] == $materi->id )
                                                        <option value="{{ $materi->id }}" selected>{{ $materi->nama_materi }}</option>
                                                    @else
                                                        <option value="{{ $materi->id }}">{{ $materi->nama_materi }}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <optgroup label="{{ $programs[$i]->aktivasi[0]->nama_aktivasi }}">  
                                            @foreach( $materis as $materi )
                                                @if( $materi->program_id == $programs[$i]->id )
                                                    @if( $dataguru['materi_id'] == $materi->id )
                                                        <option value="{{ $materi->id }}" selected>{{ $materi->nama_materi }}</option>
                                                    @else
                                                        <option value="{{ $materi->id }}">{{ $materi->nama_materi }}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endif

                                <?php endfor; ?>
                           
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">

                        <label for="status" class="col-form-label">STATUS</label>
                        <div class="col-auto"> 
                            <select name="status" id="status" class="p-1 bg-primary text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;"> 

                                @if( $dataguru['status'] == 0 )
                                    <option value="0" selected>Belum Terlaksana</option>
                                    <option value="1">Terlaksana</option>
                                @else
                                    <option value="0">Belum Terlaksana</option>
                                    <option value="1" selected>Terlaksana</option>
                                @endif
                            
                            </select>
                        </div>
                        
                        <label for="pertemuan" class="col-form-label">PERTEMUAN</label>
                        <input type="integer" name="pertemuan" id="pertemuan" class="form-control @error('pertemuan') is-invalid @enderror" value="{{ old('pertemuan', $dataguru['pertemuan']) }}"  placeholder="example@gmail.com">
                        @error('pertemuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <label for="tanggal" class="col-form-label">TANGGAL</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $dataguru['tanggal']) }}">
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