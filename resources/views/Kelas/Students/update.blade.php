@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mx-2 border-bottom">
    <h1 class="h2">Halaman Ubah {{ $active }}</h1>
</div>
<div class="container-fluid d-flex justify-content-center my-5">
    <div class="col-lg-8">
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
        <div class="card mb-3">
            <div class="card-body">
                <main class="w-70 m-auto">
                <form action="/kelas-admin/update/student/{{ $student->id }}" method="post">
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
                        <input type="text" name="ktp" class="@error('ktp') is-invalid @enderror form-control" id="ktp" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('ktp', $student->ktp) }}" placeholder="No KTP" required>
                        <label for="ktp">No KTP</label>
                        @error('ktp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
                        <input type="text" name="status" class="@error('status') is-invalid @enderror form-control" id="status" placeholder="status@example.com" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('status',  $student->status) }}"  required>
                        <label for="status">Status</label>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="date" name="tanggal_lahir" class="@error('tanggal_lahir') is-invalid @enderror form-control" id="tanggal_lahir" placeholder="dd-mm-yyyy" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" max="{{ $date }}" value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}"  required>
                        <!-- jadi value nya di buat terbalik agar inputannya dapat menjadi tanggal-bln-tahun -->

                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="hidden" name="nomor_pendaftaran" class="@error('nomor_pendaftaran') is-invalid @enderror form-control" id="nomor_pendaftaran" placeholder="nomor_pendaftaran" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $student->nomor_pendaftaran }}"  required>
                        <input type="hidden" name="tahun_daftar" class="@error('tahun_daftar') is-invalid @enderror form-control" id="tahun_daftar" placeholder="tahun_daftar" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $year }}"  required>
                    </div>

                    <!-- <div class="form-control d-flex justify-content-between" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;"> -->
                    <div class="form-floating text-center mb-4">
                        
                        <input type="hidden" id="myInput" name="password" autocomplete="off" class="@error('password') is-invalid @enderror form-control" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" id="password" value="{{ $student->nomor_pendaftaran }}" placeholder="Password" required>
                    </div>
                    <div class="form-floating p-2">
                            <h5 class="card-text mb-3">Program tersedia pada kurikulum {{ $student->kurikulum->nama_kurikulum }}</h5>
                            
                            @foreach( $programs as $program )
                                <ul class="list-group">
                                    <li class="list-group-item">{{ $program->nama_program }}</li>
                                </ul>
                            @endforeach
                    <!-- </div> -->
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="w-45 btn btn-primary mx-2 text-center d-flex justify-content-center align-items-center" type="submit">Ubah Data<i class="fa-solid fa-file-pen mx-2"></i></button>
                        <a href="/kelas-admin/show/{{ $student->kurikulum_id}}" class="btn btn-primary text-decoration-none text-light" style="height: 50%;">
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
    
</script>
@endpush