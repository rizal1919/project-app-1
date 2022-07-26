@extends('Dashboard.Layouts.main')



@section('container')
<!-- <div class="row justify-content-center mt-5" style='height: 500px; margin-left: 50px; margin-bottom: 100px;'>
    <div class="col-lg-10">
        @if( session('pendaftaranGagal') )
        <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('pendaftaranGagal') }}</strong> Pilihan paket belum dipilih.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('pendaftaranBerhasil') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('pendaftaranBerhasil') }}</strong> adalah username dan password anda untuk dapat login. Simpan nomor dengan sebaik-baiknya.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form action="/pendaftaran" method="post">
                    @csrf
                    <h1 class="h3 mb-4 fw-normal text-center"></i>Form Pendaftaran Siswa Baru</h1>
                    <div class="d-flex flex-row mb-3 border border-primary">
                        <div class="d-flex flex-column mb-3 mx-5 border border-warning">
                            <div class="col-auto">
                                <label for="inputPassword6" class="col-form-label">Password</label>
                            </div>
                            <div class="col-auto">
                                <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                            </div>
                            <div class="mb-3">
                                <label for="nama_siswa" class="form-label d-inline">Nama Lengkap</label>
                                <input type="text" name="nama_siswa" class="@error('nama_siswa') is-invalid @enderror form-control" id="nama_siswa" style="border-radius: 5px 5px 0px 0px; margin-bottom: -1px;" value="{{ old('nama_siswa') }}" autofocus required>
                                @error('nama_siswa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="text" name="ktp" class="@error('ktp') is-invalid @enderror form-control" id="ktp" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('ktp') }}" placeholder="No KTP" required>
                                <label for="ktp">No KTP</label>
                                @error('ktp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" placeholder="email@example.com" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('email') }}"  required>
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-3 border border-warning">
                            <div class="mb-3">
                                <input type="date" name="tanggal_lahir" class="@error('tanggal_lahir') is-invalid @enderror form-control" id="tanggal_lahir" placeholder="dd-mm-yyyy" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" max="{{ $date }}" value="19-06-1999"  required>
                                jadi value nya di buat terbalik agar inputannya dapat menjadi tanggal-bln-tahun -->

                                <!-- <label for="tanggal_lahir">Tanggal Lahir</label>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <input type="hidden" name="nomor_pendaftaran" class="@error('nomor_pendaftaran') is-invalid @enderror form-control" id="nomor_pendaftaran" placeholder="nomor_pendaftaran" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $nomor }}"  required>
                                <input type="hidden" name="tahun_daftar" class="@error('tahun_daftar') is-invalid @enderror form-control" id="tahun_daftar" placeholder="tahun_daftar" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $year }}"  required>
                            </div> -->
                            <!-- <div class="form-control d-flex justify-content-between" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;">
                                <label for="program_id" placeholder="Pilihan 1">Pilihan Paket</label>
                                <select name="program_id" id="program_id" class="p-1 bg-secondary text-center text-light" style="border-radius: 5px;">

                                    <option value="0">Tidak memilih paket</option>

                                
                                    @foreach( $programs as $program )
                                    <option value="{{ $program['id'] }}">{{ $program['nama_program'] }}</option>
                                    @endforeach
                                
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" id="myInput" name="password" autocomplete="off" class="@error('password') is-invalid @enderror form-control" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" id="password" value="{{ $nomor }}" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary mt-3 mb-3" type="submit">Daftar</button>
                    
                </form>
            </div>
        </div> 
    </div>-->

    <div class="container d-flex justify-content-center mt-4">
        <div class="card col-10 justify-content-center">
            <div class="card-header">
                <p class="card-title">
                    Form Registrasi
                </p>
            </div>
            <div class="card-body">
                <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
            </div>
            <form action="" method="post">
                <div class="row p-4 align-items-start justify-content-center">
                    <div class="col-auto mx-5">
                        <label for="nama_siswa" class="col-form-label">NAMA</label>
                        <input type="text" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}">
                        @error('nama_siswa')
                        <div class="invalid-feedback">
                            {{ @message }}
                        </div>
                        @enderror

                        <label for="ktp" class="col-form-label">KTP</label>
                        <input type="text" id="ktp" class="form-control @error('ktp') is-invalid @enderror" value="{{ old('ktp') }}">
                        @error('ktp')
                        <div class="invalid-feedback">
                            {{ @message }}
                        </div>
                        @enderror

                        <label for="email" class="col-form-label">EMAIL</label>
                        <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ @message }}
                        </div>
                        @enderror

                        <label for="tanggal_lahir" class="col-form-label">TANGGAL LAHIR</label>
                        <input type="text" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            {{ @message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-auto">
                        
                        <!-- <label for="email" class="col-form-label">EMAIL</label>
                        <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ @message }}
                        </div>
                        @enderror -->

                        <label for="paket_pilihan" class="col-form-label">PILIHAN PAKET</label>
                        <div class="col-auto"> 
                            <select name="program_id" id="program_id" class="p-1 bg-primary text-center text-light" style="border-radius: 5px; border: 0px solid white; width: 100%;">

                                <option value="0">Tidak memilih paket</option>
                                @foreach( $kurikulums as $kurikulum )
                                <option value="{{ $kurikulum['id'] }}">{{ $kurikulum['nama_kurikulum'] }}</option>
                                @endforeach
                            
                            </select>
                        </div>

                    </div>
                </div>
                <div class="row d-flex justify-content-end mx-3 mt-3">
                    <div class="col-10 p-2 d-flex justify-content-center align-items-end">
                        <p><em><small>Pastikan semua data terisi dengan benar. Anda tidak dapat kembali ke halaman ini setelah mengklik tombol submit data.</small></em></p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa-solid fa-arrow-up-right-from-square mx-1"></i>Submit Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
   
    <!-- <div class="col-lg-6 mx-5">
        <?php $jumlahDataProgramTersedia = $count ?>
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Program Details</p>
                </div>
                <div class="card-body" style="height: 400px; overflow:scroll;">
                    <div class="col-12">
                        <?php $i=0; ?>
                        @for( $i=0; $i<$jumlahDataProgramTersedia; $i++ )

                            <?php $count= $jumlahDataProgramTersedia-($jumlahDataProgramTersedia-$i); ?>
                            @if( $i == $count )
                                <button onclick="details('{{ $i }}')" class="btn btn-primary d-block mt-1 text-start tombol" id="pencet" style="width: 100%; border-radius: 5px 5px 0px 0px;" value="0">{{ $programs[$i]['nama_program'] }}<i id="icon" data-icon-type="{{ $i }}" class="fa-solid fa-arrow-right mx-3"></i>
                                </button>
                                <div class="card" style="border-radius: 0px 0px 5px 5px;">
                                    <div class="card-body">
                                    <p id="kalimat" data-id-type="{{ $i }}" class="card-body text-center align-items-center mx-auto my-auto" style="height: 100%; display: none;">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Qui, in! Consequatur quidem velit, fugit porro laudantium maxime, voluptatibus quis beatae, nemo hic inventore! Voluptates facere, ad ipsa ipsum ducimus voluptas ex commodi vero numquam voluptatem perferendis dolores nulla magnam? A nemo voluptatem impedit consequuntur quae, soluta totam fuga esse eos laudantium quasi quisquam quod quia, cum distinctio eum tempore consectetur. 
                                        
                                        Officiis, nemo natus corrupti voluptas veritatis quidem enim quas. Ea, error eos? Dignissimos consequuntur, eaque accusantium labore atque officiis officia, ullam eveniet sint aperiam maxime corrupti, ducimus culpa recusandae reprehenderit ea beatae non amet! Autem dicta nostrum voluptates dolore quasi.
                                    </p>
                                    </div>
                                </div>
                            @endif

                        
                        @endfor
                        
                       
                    </div>
                </div>
                <div class="card-footer text-end p-4" style="height: 40%; font-size: 10px;">
                    <div class="col-12" >
                        <p class="card-text text-default fs-10">
                            <em>Copyright By Short Course Academy <mark> Since 2022</mark>.</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
</div> -->

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