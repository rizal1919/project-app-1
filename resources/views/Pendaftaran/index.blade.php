@extends('Layouts.main')



@include('Layouts/Navbar/navbar')
@section('content')
<div class="row justify-content-center mt-5" style='height: 500px; margin-left: 50px; margin-bottom: 100px;'>
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
                    <div class="form-floating">
                        <input type="text" name="nama_siswa" class="@error('nama_siswa') is-invalid @enderror form-control" id="nama_siswa" style="border-radius: 5px 5px 0px 0px; margin-bottom: -1px;" placeholder="Nama Lengkap" value="{{ old('nama_siswa') }}" autofocus required>
                        <label for="nama_siswa">Nama Lengkap</label>
                        @error('nama_siswa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="text" name="ktp" class="@error('ktp') is-invalid @enderror form-control" id="ktp" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('ktp') }}" placeholder="No KTP" required>
                        <label for="ktp">No KTP</label>
                        @error('ktp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" placeholder="email@example.com" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('email') }}"  required>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="date" name="tanggal_lahir" class="@error('tanggal_lahir') is-invalid @enderror form-control" id="tanggal_lahir" placeholder="dd-mm-yyyy" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" max="{{ $date }}" value="19-06-1999"  required>
                        <!-- jadi value nya di buat terbalik agar inputannya dapat menjadi tanggal-bln-tahun -->

                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="hidden" name="nomor_pendaftaran" class="@error('nomor_pendaftaran') is-invalid @enderror form-control" id="nomor_pendaftaran" placeholder="nomor_pendaftaran" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $nomor }}"  required>
                        <input type="hidden" name="tahun_daftar" class="@error('tahun_daftar') is-invalid @enderror form-control" id="tahun_daftar" placeholder="tahun_daftar" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $year }}"  required>
                    </div>

                    <div class="form-control d-flex justify-content-between" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;">
                        <label for="program_id" placeholder="Pilihan 1">Pilihan Paket</label>
                        <select name="program_id" id="program_id" class="p-1 bg-secondary text-center text-light" style="border-radius: 5px;">

                            <option value="0">Tidak memilih paket</option>

                           
                            @foreach( $programs as $program )
                            <option value="{{ $program['id'] }}">{{ $program['nama_program'] }}</option>
                            @endforeach
                          
                        </select>
                    </div>
                    <div class="form-floating">
                        
                        <input type="hidden" id="myInput" name="password" autocomplete="off" class="@error('password') is-invalid @enderror form-control" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" id="password" value="{{ $nomor }}" placeholder="Password" required>
                        <!-- <label for="password">Password</label> -->
                        <!-- <div class="my-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="myFunction()">
                            <label class="form-check-label" for="exampleCheck1">Lihat password</label>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror -->
                    </div>
                    <button class="w-100 btn btn-lg btn-primary mt-3 mb-3" type="submit">Daftar</button>
                    
                </form>
            </div>
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