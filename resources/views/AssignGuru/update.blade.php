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
            @if( session('updateFailed') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('updateFailed') }}</strong> materi sudah ada guru
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    Form Assign Guru
                </p>
            </div>
           
            @if( $penugasan['isNew'] )
                <form action="/assign-teacher-create" method="post">
                    @csrf
                    <div class="row p-4">
                        <div class="row my-3 text-end d-flex justify-content-center">
                            <label for="teacher_id" class="col-sm-3 col-form-label col-form-label-sm fw-bold text-end">Guru</label>
                            <div class="col-sm-7 text-end">
                                <select name="teacher_id" id="teacher_id" class="form-select form-select-sm">

                                    <option selected disabled>Pilih Guru ...</option>
                                    @foreach( $teachers as $teacher )
                                        <option value="{{ $teacher['id'] }}">{{ $teacher['teacher_name'] }}</option>
                                    @endforeach
                                
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Pilihan Paket</label>
                            <div class="col-sm-7">
                                <select name="aktivasi_id" id="paket" class="form-select form-select-sm">
                                    <option selected disabled>Pilih Paket ...</option>
                                    @foreach( $aktivasis as $aktivasi )
                                        <option value="{{ $aktivasi->id }}">{{ $aktivasi->nama_aktivasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="materi_id" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Materi Tersedia</label>
                            <div class="col-sm-7">
                                <select name="materi_id" id="materi_id" class="form-select form-select-sm">
                                    <option>Pilih Paket Dulu ...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="status" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Status</label>
                            <div class="col-sm-7">
                                <select name="status" id="status" class="form-select form-select-sm">
                                    <option selected disabled>Pilih Status ...</option>
                                    <option value="1">Terlaksana</option>
                                    <option value="0">Belum Terlaksana</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="date" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Tanggal Pertemuan</label>
                            <div class="col-sm-7">
                                <div class="date" id="datepicker">
                                    <input type="text" name="tanggal" autocomplete="off" class="form-control form-control-sm" placeholder="dd/mm/yyyy">
                                    <span class="input-group-append" style="display: none;">
                                        <span class="input-group-text bg-white d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
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
            @else
                <form action="/assign-teacher-update/{{ $penugasan['idMateri'] }}" method="post">
                    @csrf
                    <div class="row p-4">
                        
                        <div class="row my-3 text-end d-flex justify-content-center">
                            <label for="teacher_id" class="col-sm-3 col-form-label col-form-label-sm fw-bold text-end">Guru</label>
                            <div class="col-sm-7 text-end">
                                <select name="teacher_id" id="teacher_id" class="form-select form-select-sm">

                                    <option selected disabled>Pilih Guru ...</option>
                                    @foreach( $teachers as $teacher )
                                        @if( $teacher['id'] === $penugasan['idGuru'] )
                                            <option value="{{ $teacher['id'] }}" selected>{{ $teacher['teacher_name'] }}</option>
                                        @else
                                            <option value="{{ $teacher['id'] }}">{{ $teacher['teacher_name'] }}</option>
                                        @endif
                                    @endforeach
                                
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Pilihan Paket</label>
                            <div class="col-sm-7">
                                <select name="aktivasi_id" id="paket" class="form-select form-select-sm text-bg-secondary">
                                    <option selected disabled>Pilih Paket ...</option>
                                    @foreach( $aktivasis as $aktivasi )
                                        @if( $aktivasi->id === $penugasan['idAktivasi'] )
                                            <option value="{{ $aktivasi->id }}" selected>{{ $aktivasi->nama_aktivasi }}</option>
                                        @else
                                            <option value="{{ $aktivasi->id }}" disabled>{{ $aktivasi->nama_aktivasi }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="materi_id" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Materi Tersedia</label>
                            <div class="col-sm-7">
                                <select name="materi_id" id="materi_id" class="form-select form-select-sm text-bg-secondary">
                                    <option value="{{ $penugasan['idMateri'] }}">{{ $penugasan['namaMateri'] }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="status" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Status</label>
                            <div class="col-sm-7">
                                <select name="status" id="status" class="form-select form-select-sm">
                                    <option selected disabled>Pilih Status ...</option>
                                    @if( $penugasan['status'] === 0 )
                                        <option value="0" selected>Belum Terlaksana</option>
                                        <option value="1">Terlaksana</option>
                                    @else
                                        <option value="0">Belum Terlaksana</option>
                                        <option value="1" selected>Terlaksana</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 text-end d-flex justify-content-center">
                            <label for="date" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Tanggal Pertemuan</label>
                            <div class="col-sm-7">
                                <div class="date" id="datepicker">
                                    <input type="text" value="{{ old('tanggal', $penugasan['tanggal']) }}" autocomplete="off" name="tanggal" class="form-control form-control-sm" placeholder="dd/mm/yyyy">
                                    <span class="input-group-append" style="display: none;">
                                        <span class="input-group-text bg-white d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end mx-3 mt-3">
                        <div class="col-7 p-2 d-flex justify-content-center align-items-end">
                            <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary"><i class="fas fa-pen-to-square mx-2"></i>Update</button>
                            <a href="/assign-teacher" class="btn btn-primary">Kembali</a>
                        </div>
                        
                    </div>
                </form>
            @endif
        </div>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="card col-lg-12">
            <div class="card-header">
                <p class="card-title">Daftar Penugasan</p>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped table-light" id="table">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Materi</td>
                            <td>Guru Ditugaskan</td>
                            <td>Status</td>
                            <td>Tanggal</td>
                        </tr>
                    </thead>
                    <tbody id="data_teacher">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php $cek = $penugasan['isNew']; ?> 
    <p id="penugasan" hidden><?php echo $cek; ?></p>
<script>

    $(document).ready(function(){

        $(function(){
            $('#datepicker').datepicker();
        });
        
       let val = document.getElementById('penugasan').innerText;
       if(val == false){
        
            $('#paket').ready(function(){
                var value = $('#paket').val();
                $.ajax({
                    url:"{{ route('getteacher') }}",
                    type:"GET",
                    data:{'aktivasi_id':value},
                    success: function(data){
                        console.log(data);
                        $('#data_teacher').html(data);           
                        
                    }
                });
            });
       }

        $('#paket').on('change', function(){
            var value = $('#paket').val();
            $.ajax({
                url:"{{ route('getmateri') }}",
                type:"GET",
                data:{'id_paket':value},
                success: function(data){
                    console.log(data);
                    $('#materi_id').html(data);           
                    
                }
            });
        });

        $('#paket').on('change', function(){
            var value = $('#paket').val();
            $.ajax({
                url:"{{ route('getteacher') }}",
                type:"GET",
                data:{'aktivasi_id':value},
                success: function(data){
                    console.log(data);
                    $('#data_teacher').html(data);           
                    
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