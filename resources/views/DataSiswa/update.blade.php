@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mx-5 pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Ubah {{ $active }}</h1>
</div>
<div class="container-lg d-flex justify-content-center mt-5">
    <div class="col-lg-6">
        @if( session('updateGagal') )
        <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('updateGagal') }}</strong> Pilihan paket belum dipilih.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('updateBerhasil') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('updateBerhasil') }}</strong> Data telah tersimpan.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <main class="w-70 m-auto">
                <form action="/data-siswa/update/student/{{ $student->id }}" method="post">
                    @csrf
                    <h1 class="h3 mb-4 fw-normal text-center"></i>Update Informasi Siswa {{ $student->nama_siswa }}</h1>
                    <div class="form-floating">
                        <input type="text" name="nama_siswa" class="@error('nama_siswa') is-invalid @enderror form-control" id="nama_siswa" style="border-radius: 5px 5px 0px 0px; margin-bottom: -1px;" placeholder="Nama Lengkap" value="{{ old('nama_siswa', $student->nama_siswa) }}" autofocus required>
                        <label for="nama_siswa">Nama Lengkap</label>
                        @error('nama_siswa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        
                    </div>
                    <div class="form-floating">
                        <input type="text" maxlength="16" name="ktp" id="ktp" class="@error('ktp') is-invalid @enderror form-control" id="ktp" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('ktp', $student->ktp) }}" placeholder="No KTP" required>
                        <label for="ktp">No KTP</label>
                        @error('ktp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <p id="karakter" style="margin-top: 2px;" hidden></p>
                    </div>
                    <div class="form-floating">
                        <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" placeholder="email@example.com" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('email', $student->email) }}"  required>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="date" name="tanggal_lahir" class="@error('tanggal_lahir') is-invalid @enderror form-control" id="tanggal_lahir" placeholder="dd-mm-yyyy" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" max="{{ $date }}" value="{{ $student->tanggal_lahir }}"  required>
                        <!-- jadi value nya di buat terbalik agar inputannya dapat menjadi tanggal-bln-tahun -->

                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="hidden" name="nomor_pendaftaran" class="@error('nomor_pendaftaran') is-invalid @enderror form-control" id="nomor_pendaftaran" placeholder="nomor_pendaftaran" value="{{ $student->nomor_pendaftaran }}"  required>
                        <input type="hidden" name="tahun_daftar" class="@error('tahun_daftar') is-invalid @enderror form-control" id="tahun_daftar" placeholder="tahun_daftar" value="{{ $year }}"  required>
                    </div>
                    <div class="form-floating text-center mb-4">
                        
                        <input type="hidden" id="myInput" name="password" autocomplete="off" class="@error('password') is-invalid @enderror form-control" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" id="password" value="{{ $student->nomor_pendaftaran }}" placeholder="Password" required>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button class="w-45 btn btn-primary mx-2 text-center d-flex justify-content-center align-items-center" type="submit"><i class="fas fa-pen-to-square mx-2"></i>Ubah Data</button>
                        <a href="/data-siswa" class="btn btn-primary text-decoration-none text-light" style="height: 50%;">
                            Kembali
                        </a>
                    </div>
                </form>
                
                </main>
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
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
@endpush