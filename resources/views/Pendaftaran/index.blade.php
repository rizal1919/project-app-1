@extends('Layouts.main')


@section('content')
    <div class="row align-items-center" style='height: 500px; margin-left: 100px;'>
        <div class="col-lg-4">
        <main class="w-80 m-auto">
        <form action="#" method="post">
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
                <input type="number" name="ktp" class="@error('ktp') is-invalid @enderror form-control" id="ktp" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('ktp') }}" placeholder="No KTP" required>
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
                <input type="date" name="tanggal_lahir" class="@error('tanggal_lahir') is-invalid @enderror form-control" id="tanggal_lahir" placeholder="tanggal_lahir" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('tanggal_lahir') }}"  required>
                <label for="tanggal_lahir">Tanggal Lahir</label>
                @error('tanggal_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <input type="hidden" name="nomor_pendaftaran" class="@error('nomor_pendaftaran') is-invalid @enderror form-control" id="nomor_pendaftaran" placeholder="nomor_pendaftaran" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $nomor }}"  required>
                <input type="hidden" name="tahun_daftar" class="@error('tahun_daftar') is-invalid @enderror form-control" id="tahun_daftar" placeholder="tahun_daftar" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $year }}"  required>
            </div>

            <div class="form-floating">
                <label for="nis" placeholder="Nomor Induk Siswa">Nomor Induk Siswa</label>
                <select name="nis" id="nis">
                    @foreach( $programs as $program )
                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                    @endforeach
                </select>
                
            </div>
            <div class="form-floating">
                <input type="password" id="myInput" name="password" autocomplete="off" class="@error('password') is-invalid @enderror form-control" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" id="password" placeholder="Password" required>
                <label for="password">Password</label>
                <div class="my-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="myFunction()">
                    <label class="form-check-label" for="exampleCheck1">Lihat password</label>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-2 mb-3" type="submit">Daftar</button>
            
        </form>
        <!-- <div class="col-lg-12 text-center">
            <p class="text-center d-inline mx-1 ">Sudah pernah mendaftar?</p><a class="text-decoration-none button-registered-or-unregistered " href="/login-admin">Masuk</a>
        </div> -->
        </main>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Program Details</p>
                </div>
                <div class="card-body" style="height: 350px;">
                    <div class="col-12">
                        
                            <!-- <button class="btn btn-primary d-block mt-1 text-start" id="button" style="width: 100%;"><i class="fa-solid fa-arrow-right"></i>
                            </button> -->
                            <p class="btn btn-primary" id="button">
                            {{ $programs[0]->nama_program }}<i class="fa-solid fa-arrow-right"></i>
                            </p>
                            <p id="body" class="card-body text-center align-items-center mx-auto my-auto" style="height: 100%;">
                                No Post Found
                            </p>
                       
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-primary d-inline" onclick="left()"><i class="fa-solid fa-arrow-left mx-1"></i>Klik</button>
                        <p id="counter" class="btn btn-warning d-inline" onclick="right('{{ $count }}')">0</p>
                    <button class="btn btn-primary" onclick="right('{{ $count }}')">Klik<i class="fa-solid fa-arrow-right mx-1"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!-- <p id="demo" onclick="Function()">Click me to change my HTML content (innerHTML).</p> -->

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

    
    
    
    

    function left(){

        // alert(element);
        let element = document.getElementById("counter").innerHTML;
        document.getElementById("button").innerHTML = `{{ $programs[0]->nama_program }}`;

        if( element == 0 ){
            element = element;

            // alert(element);
            document.getElementById("counter").innerHTML = element;
            document.getElementById("button").innerHTML = `{{ $programs[0]->nama_program }}`;
        }else if( element > 0 )
        {   
            alert(element);
            element = Number(element)-1;
            document.getElementById("counter").innerHTML = element;
            document.getElementById("button").innerHTML = `{{ $programs[0]->nama_program }}`;
        }

        // let judul = document.getElementById("button").innerHTML;
        

    }

    function right(counters){

        let element = document.getElementById("counter").innerHTML;

        if( element == counters ){

            element = element;
            document.getElementById("counter").innerHTML = element;
            document.getElementById("button").innerHTML = `{{ $programs[0]->nama_program }}`;

        }else{
            element = Number(element)+1;
            document.getElementById("counter").innerHTML = element;
            document.getElementById("button").innerHTML = `{{ $programs[0]->nama_program }}`;
        }

        
    }


    // function details(id, count){

        
    //     document.getElementById('')
    //     var x = element.getAttribute('value');
    //     // alert(x);
        
        
        
    //     if( x == 1 ){
    //         document.getElementById("body").style.height = "200px";
    //         document.getElementById('baten').value="0";
    //     }else{
    //         document.getElementById("body").style.height = "0px";
    //         document.getElementById('baten').value="1";
    //     }

    // }
</script>
@endpush