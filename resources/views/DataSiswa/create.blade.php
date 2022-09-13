@extends('Dashboard.Layouts.main')

@section('container')

<form action="/data-siswa/create/student" id="formTambahSiswa" method="post" enctype="multipart/form-data">
    <div class="container d-flex justify-content-center mt-4 mb-2">
        <div class="card col-12 justify-content-center">
            @if( session('pendaftaranGagal') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('pendaftaranGagal') }}</strong> paket pilihan harus dipilih.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('pendaftaranBerhasil') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('pendaftaranBerhasil') }}</strong> adalah kode untuk aktivasi program.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    <strong>Form A</strong> - Keterangan Calon Peserta Didik
                </p>
            </div>
            <!-- <div class="card-body">
                <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
            </div> -->
                @csrf
                <div class="d-flex justify-content-center p-4">
                    <div class="col-lg-10 mx-4 text-start">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <img src="/img/profile.jpg" id="imgInp" class="img-thumbnail" alt="profile.jpg">
                            </div>
                            <div class="col-md-7" style="margin-top: 70px;">
                                <label class="col-form-label col-form-label-sm fw-bold">Foto Profil</label>
                                <input class="form-control form-control-sm @error('picture') is-invalid @enderror" name="picture" id="formFileSm" type="file">
                                <p class="form-text">Ukuran file maks 1 Mb</p>
                                @error('picture')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nama_siswa" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Nama Lengkap</label>
                            <div class="col-sm-7">
                                <input type="text" autocomplete="on" name="nama_siswa" id="nama_siswa" class="form-control form-control-sm @error('nama_siswa') is-invalid @enderror submit" placeholder="Reiza Nurrafi" value="{{ old('nama_siswa') }}" required autofocus>
                                @error('nama_siswa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama_panggilan_siswa" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Nama Panggilan</label>
                            <div class="col-sm-7">
                                <input type="text" autocomplete="on" name="nama_panggilan_siswa" value="{{ old('nama_panggilan_siswa') }}" class="form-control form-control-sm @error('nama_panggilan_siswa') is-invalid @enderror submit" placeholder="Reiza" required>
                                @error("nama_panggilan_siswa")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis_kelamin" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Jenis Kelamin</label>
                            <div class="col-sm-7">
                                <select name="jenis_kelamin" class="form-select form-select-sm submit" id="jenis_kelamin">
                                    <option>Pilih Jenis Kelamin</option>
                                    <option value="Pria">Laki-Laki</option>
                                    <option value="Wanita">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ktp" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Kartu Tanda Penduduk (KTP)</label>
                            <div class="col-sm-7">
                                <input type="number" autocomplete="on" name="ktp" id="ktp" class="form-control form-control-sm @error('ktp') is-invalid @enderror submit" value="{{ old('ktp') }}" autocomplete="off" placeholder="3521515890880004" required>
                                @error('ktp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <p id="karakter" class="form-text" style="margin-top: 2px; margin-left: 220px;" hidden></p>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Email</label>
                            <div class="col-sm-7">
                                <input type="email" autocomplete="on" name="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror submit" value="{{ old('email') }}" placeholder="example@gmail.com" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label for="tempat_lahir" class="col-form-label col-form-label-sm fw-bold">Tempat / Tanggal Lahir</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" autocomplete="on" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control form-control-sm col-sm-4 @error('tempat_lahir') is-invalid @enderror submit" placeholder="Surabaya" required>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal_lahir" class="form-control form-control-sm col-sm-4 submit" value="{{ old('tanggal_lahir') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-3 col-form-label col-form-label-sm fw-bold submit">Agama</label>
                            <div class="col-sm-7">
                                <select name="agama" id="agama" class="form-select form-select-sm">
                                    <option value="">Pilih salah satu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Protestan">Protestan</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Khonghucu">Khonghucu</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label for="nama_jalan_ktp" class="col-form-label col-form-label-sm fw-bold">Alamat Tinggal (Sesuai KTP)</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" autocomplete="on" value="{{ old('nama_jalan_ktp') }}" class="form-control form-control-sm submit" id="nama_jalan_ktp" name="nama_jalan_ktp" required placeholder="Jalan Raya Kencana 1 Blok AB" required>
                            </div>
                            <div class="col-md-1">
                                <input type="number" autocomplete="on" value="{{ old('rt_ktp') }}" name="rt_ktp" class="form-control form-control-sm submit" id="rt_ktp" placeholder="RT" required>
                            </div>
                            <div class="col-md-1">
                                <input type="number" autocomplete="on" name="rw_ktp" value="{{ old('rw_ktp') }}" class="form-control form-control-sm submit" id="rw_ktp" placeholder="RW" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <input type="text" autocomplete="on" value="{{ old('nama_desa_ktp') }}" class="form-control form-control-sm submit" id="nama_desa_ktp" name="nama_desa_ktp" required placeholder="Gayungan">
                            </div>
                            <div class="col-md-4">
                                <input type="text" autocomplete="on" value="{{ old('nama_kecamatan_ktp') }}" name="nama_kecamatan_ktp" class="form-control form-control-sm submit" id="nama_kecamatan_ktp" placeholder="Ketintang" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label for="nama_jalan_domisili" class="col-form-label col-form-label-sm fw-bold">Alamat Tinggal (Domisili)</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" autocomplete="on" value="{{ old('nama_jalan_domisili') }}" id="nama_jalan_domisili" class="form-control form-control-sm submit" name="nama_jalan_domisili" required placeholder="Jalan Raya Kencana 1 Blok AB">
                            </div>
                            <div class="col-md-1">
                                <input type="number" autocomplete="on" value="{{ old('rt_domisili') }}" id="rt_domisili" name="rt_domisili" class="form-control form-control-sm submit" id="rt_domisili" placeholder="RT" required>
                            </div>
                            <div class="col-md-1">
                                <input type="number" autocomplete="on" value="{{ old('rw_domisili') }}" id="rw_domisili" name="rw_domisili" class="form-control form-control-sm submit" id="rw_domisili" placeholder="RW" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <input type="text" autocomplete="on" value="{{ old('nama_desa_domisili') }}" id="nama_desa_domisili" class="form-control form-control-sm submit" name="nama_desa_domisili" required placeholder="Gayungan">
                            </div>
                            <div class="col-md-4">
                                <input type="text" autocomplete="on" value="{{ old('nama_kecamatan_domisili') }}" id="nama_kecamatan_domisili" name="nama_kecamatan_domisili" class="form-control form-control-sm submit" id="nama_kecamatan_domisili" placeholder="Ketintang" required>
                            </div>
                        </div>

                        <!-- form cek alamat sama dengan ktp -->
                        <div class="form-check col-lg-4" style="margin-left: 195px;">
                            <input type="checkbox" id="alamat-sama" value="0" class="form-check-input mx-2" style="margin-right: 5px;" name="alamat_sama" id="alamat_sama">
                            <label for="alamat-sama" class="form-check-label text-secondary">Alamat sama dengan di ktp</label>
                        </div>

                        <div class="row my-3">
                            <label for="tempat_tinggal" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Tempat Tinggal</label>
                            <div class="col-sm-7">
                                <select name="tempat_tinggal" id="tempat_tinggal" class="form-select form-select-sm submit" required>
                                    <option>Pilih salah satu</option>
                                    <option value="Bersama Orang Tua">Bersama Orang Tua</option>
                                    <option value="Kost">Kost</option>
                                    <option value="Rumah Pribadi">Rumah Pribadi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label for="transportasi" class="col-sm-3 col-form-label col-form-label-sm fw-bold">Transportasi</label>
                            <div class="col-sm-7">
                                <select name="transportasi" id="transportasi" class="form-select form-select-sm submit" required>
                                    <option value="">Pilih salah satu</option>
                                    <option value="Sepeda Motor">Sepeda Motor</option>
                                    <option value="Angkutan Umum">Angkutan Umum</option>
                                    <option value="Jalan Kaki">Jalan Kaki</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label for="no_hp" class="col-sm-3 col-form-label col-form-label-sm fw-bold">No Telfon</label>
                            <div class="col-sm-7">
                                <input type="number" id="no_hp" autocomplete="on" value="{{ old('no_hp') }}" name="no_hp" id="no_hp" class="form-control form-control-sm submit" placeholder="085xxxxxxxxx" required>
                            </div>
                            <p class="form-text" style="margin-left: 220px;">Harap untuk menginputkan nomor yang masih bisa dihubungi</p>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label for="asal_sekolah" class="col-form-label col-form-label-sm fw-bold">Asal Sekolah (SMA/SMK/MTS)</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" autocomplete="on" value="{{ old('asal_sekolah') }}" name="asal_sekolah" id="asal_sekolah" class="form-control form-control-sm submit" placeholder="SMAN 1 HARAPAN BARU" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" autocomplete="on" value="{{ old('kota_asal_sekolah') }}" name="kota_asal_sekolah" class="form-control form-control-sm submit" id="kota_asal_sekolah" placeholder="Surabaya" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pic_id" class="col-md-3 col-form-label col-form-label-sm fw-bold">PIC</label>
                            <div class="col-md-7">
                                <select name="pic_id" class="form-select form-select-sm submit" id="pic_id">
                                    <option value="0">Pilih PIC</option>
                                    @foreach( $pics as $pic )
                                        <option value="{{ $pic->id }}">{{ $pic->nama_pic }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <input type="hidden" name="nomor_pendaftaran" class="@error('nomor_pendaftaran') is-invalid @enderror form-control" id="nomor_pendaftaran" placeholder="nomor_pendaftaran" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $nomor }}"  required>
                        <input type="hidden" name="tahun_daftar" class="@error('tahun_daftar') is-invalid @enderror form-control" id="tahun_daftar" placeholder="tahun_daftar" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $year }}"  required>
                        <input type="hidden" name="password" class="@error('password') is-invalid @enderror form-control" id="password" placeholder="password" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ $nomor }}"  required>
                    </div>

                </div>
                
        </div>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="card col-lg-12">
            <div class="card-header">
                <p class="card-title"><strong>Form B</strong> - Keterangan Orang Tua Kandung Peserta Didik</p>
            </div>
            <div class="card-body text-start p-4" style="margin-left: 50px;">
                <div class="row g-3 mt-3 mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label col-form-label-sm fw-bold">Nama Ayah / Nama Ibu</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" autocomplete="on" name="nama_ayah" value="{{ old('nama_ayah') }}" id="nama_ayah" class="form-control form-control-sm submit" placeholder="Nama Ayah" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" autocomplete="on" name="nama_ibu" value="{{ old('nama_ibu') }}" id="nama_ibu" class="form-control form-control-sm submit" placeholder="Nama Ibu" required>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label col-form-label-sm fw-bold">Tanggal Lahir / Pendidikan Terakhir Ayah</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}" id="tanggal_lahir_ayah" class="form-control form-control-sm submit" >
                    </div>
                    <div class="col-md-3">
                        <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-select form-select-sm submit" required>
                            <option value="">Pilih salah satu</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SLTA/SEDERAJAT">SLTA/SEDERAJAT</option>
                            <option value="S1">SARJANA S1</option>
                            <option value="S2">SARJANA S2</option>
                            <option value="S3">SARJANA S3</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label col-form-label-sm fw-bold">Tanggal Lahir / Pendidikan Terakhir Ibu</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}" id="tanggal_lahir_ibu" class="form-control form-control-sm submit" required>
                    </div>
                    <div class="col-md-3">
                        <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-select form-select-sm submit" required>
                            <option value="">Pilih salah satu</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SLTA/SEDERAJAT">SLTA/SEDERAJAT</option>
                            <option value="S1">SARJANA S1</option>
                            <option value="S2">SARJANA S2</option>
                            <option value="S3">SARJANA S3</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label col-form-label-sm fw-bold">Pekerjaan Ayah / Ibu</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" autocomplete="on" value="{{ old('pekerjaan_ayah') }}" name="pekerjaan_ayah" placeholder="Swasta" id="pekerjaan_ayah" class="form-control form-control-sm submit" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" autocomplete="on" value="{{ old('pekerjaan_ibu') }}" name="pekerjaan_ibu" placeholder="Swasta" id="pekerjaan_ibu" class="form-control form-control-sm submit" required>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label col-form-label-sm fw-bold">Penghasilan Ayah / Ibu</label>
                    </div>
                    <div class="col-md-4">
                        <input type="number" autocomplete="on" value="{{ old('penghasilan_ayah') }}" name="penghasilan_ayah" placeholder="Penghasilan perbulan" id="penghasilan_ayah" class="form-control form-control-sm submit" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" autocomplete="on" value="{{ old('penghasilan_ibu') }}" name="penghasilan_ibu" placeholder="Penghasilan perbulan" id="penghasilan_ibu" class="form-control form-control-sm submit" required>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label col-form-label-sm fw-bold">Keterangan Ayah / Ibu</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" autocomplete="on" value="{{ old('keterangan_ayah') }}" name="keterangan_ayah" placeholder="Masih Hidup / Meninggal" id="keterangan_ayah" class="form-control form-control-sm submit" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" autocomplete="on" value="{{ old('keterangan_ibu') }}" name="keterangan_ibu" placeholder="Masih Hidup / Meninggal" id="keterangan_ibu" class="form-control form-control-sm submit" required>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label for="nama_jalan_ortu" class="col-form-label col-form-label-sm fw-bold">Alamat Tinggal (Orang Tua)</label>
                    </div>
                    <div class="col-md-5">
                        <input type="text" autocomplete="on" value="{{ old('nama_jalan_ortu') }}" id="nama_jalan_ortu" class="form-control form-control-sm submit" name="nama_jalan_ortu" required placeholder="Jalan Raya Kencana 1 Blok AB">
                    </div>
                    <div class="col-md-1">
                        <input type="number" autocomplete="on" value="{{ old('rt_ortu') }}" id="rt_ortu" name="rt_ortu" class="form-control form-control-sm submit" id="rt_ortu" placeholder="RT" required>
                    </div>
                    <div class="col-md-1">
                        <input type="number" autocomplete="on" id="rw_ortu" value="{{ old('rw_ortu') }}" name="rw_ortu" class="form-control form-control-sm submit" id="rw_ortu" placeholder="RW" required>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <input type="text" autocomplete="on" value="{{ old('nama_desa_ortu') }}" id="nama_desa_ortu" class="form-control form-control-sm submit" name="nama_desa_ortu" required placeholder="Gayungan" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" autocomplete="on" value="{{ old('nama_kecamatan_ortu') }}" id="nama_kecamatan_ortu" name="nama_kecamatan_ortu" class="form-control form-control-sm submit" id="nama_kecamatan_ortu" placeholder="Ketintang" required>
                    </div>
                </div>

                <!-- form cek alamat sama dengan domisili siswa -->
                <div class="form-check col-lg-4" style="margin-left: 220px;">
                    <input type="checkbox" id="alamat-ortu-sama" value="0" class="form-check-input mx-2" style="margin-right: 5px;" name="alamat_ortu_sama">
                    <label for="alamat-ortu-sama" class="form-check-label text-secondary">Alamat sama dengan siswa</label>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center mt-2 mb-5">
        <div class="card col-lg-12">
            <div class="card-header">
                <p class="card-title"><strong>Form C</strong> - Data Periodik Calon Peserta Didik</p>
            </div>
            <div class="card-body p-4 text-start" style="margin-left: 50px;">
                <div class="row mb-3 mt-3">
                    <label class="col-sm-3 col-form-label col-form-label-sm fw-bold">Tinggi Badan</label>
                    <div class="col-sm-6">
                        <input type="number" autocomplete="on" value="{{ old('tinggi_badan') }}" name="tinggi_badan" id="tinggi_badan" placeholder="Tinggi Badan" class="form-control form-control-sm submit" required>
                    </div>
                    <input type="text" class="col-sm-1 text-center" placeholder="CM" disabled>
                </div>
                <div class="row mb-3 mt-3">
                    <label class="col-sm-3 col-form-label col-form-label-sm fw-bold">Jarak Rumah ke Sekolah</label>
                    <div class="col-sm-6">
                        <input type="number" autocomplete="on" value="{{ old('jarak_tempuh_sekolah') }}" name="jarak_tempuh_sekolah" id="jarak_tempuh_sekolah" placeholder="Jarak Tempuh" class="form-control form-control-sm submit" autofocus required>
                    </div>
                    <input type="text" class="col-sm-1 text-center" placeholder="KM" disabled>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label for="urutan_anak" class="col-form-label col-form-label-sm fw-bold">Anak Ke</label>
                    </div>
                    <div class="col-md-2">
                        <input type="number" autocomplete="on" value="{{ old('urutan_anak') }}" name="urutan_anak" id="urutan_anak" class="form-control form-control-sm submit" placeholder="1" required>
                    </div>
                    <div class="col-md-1">
                        <label for="jumlah_saudara" class="text-center col-form-label col-form-label-sm fw-bold">Dari</label>
                    </div>
                    <div class="col-md-2">
                        <input type="number" autocomplete="on" value="{{ old('jumlah_saudara') }}" name="jumlah_saudara" id="jumlah_saudara" class="form-control form-control-sm" placeholder="1" required>
                    </div>
                    <label for="jumlah_saudara" class="col-md-2 col-form-label col-form-label-sm fw-bold">Saudara</label>
                </div>
            </div>
            <div class="row d-flex justify-content-end mx-3 mt-3">
                <div class="col-6 p-2 d-flex justify-content-center align-items-end">
                    <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                </div>
                <div class="col-auto">
                    <button id="submit" class="btn btn-primary"><i class="fa-solid fa-database mx-2"></i>Tambah Siswa</button>
                    <a href="/data-siswa" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</form>


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

    let formFile = document.getElementById('formFileSm');
    let imgInp = document.getElementById('imgInp');

    formFile.onchange = evt => {
    const [file] = formFile.files
        if (file) {
            imgInp.src = URL.createObjectURL(file)
        }
    }



    let cariValue = document.querySelectorAll('.submit');
    let sub = document.getElementById('submit');
    sub.setAttribute('disabled', '');
    let form = document.getElementById('formTambahSiswa');
    console.log()
    form.addEventListener('change', function(){

        console.log(cariValue);
        for( const submit of cariValue ){
    
            if( submit.value === "" ){
                console.log(submit.getAttribute('id'));
                console.log("Button : disabled");
                sub.setAttribute('disabled','');
                break;
            }else if( submit.value !== "" ){
                console.log("Button : available");
                sub.removeAttribute('disabled');
           }
        }
    });


    function changeStyle(){
        var element = document.getElementById("hide");
        element.style.display = "none"; 
    }



    let ktp = document.getElementById('ktp');
    let ktpubah = document.getElementById('karakter');
    function sisaKarakter(){
        let valueInput = ktp.value;
        let panjangInputan = valueInput.length;
        // alert(panjangInputan);
        if( panjangInputan <= 16 ){

            let valueMax = '16';
            let sisa = valueMax-panjangInputan;
            let kalimatSisa = 'Sisa karakter : ' + sisa;
            ktpubah.removeAttribute('hidden');
            ktpubah.innerText = kalimatSisa;
            console.log(kalimatSisa);
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


    let cekbox = document.getElementById('alamat-sama');
    let namaJalanKTP = document.getElementById('nama_jalan_ktp');
    let rtKTP = document.getElementById('rt_ktp');
    let rwKTP = document.getElementById('rw_ktp');
    let namaDesaKTP = document.getElementById('nama_desa_ktp');
    let namaKecamatanKTP = document.getElementById('nama_kecamatan_ktp');

    let namaJalanDomisili = document.getElementById('nama_jalan_domisili');
    let rtDomisili = document.getElementById('rt_domisili');
    let rwDomisili = document.getElementById('rw_domisili');
    let namaDesaDomisili = document.getElementById('nama_desa_domisili');
    let namaKecamatanDomisili = document.getElementById('nama_kecamatan_domisili');

    cekbox.addEventListener('change', function(){
        let dome = cekbox.getAttribute('value');
        


        if( dome == 0 ){
            cekbox.setAttribute('value', 1);

            namaJalanDomisili.value = namaJalanKTP.value;
            namaJalanDomisili.setAttribute('readonly', '');
            rtDomisili.value = rtKTP.value;
            rtDomisili.setAttribute('readonly', '');
            rwDomisili.value = rwKTP.value;
            rwDomisili.setAttribute('readonly', '');
            namaDesaDomisili.value = namaDesaKTP.value;
            namaDesaDomisili.setAttribute('readonly', '');
            namaKecamatanDomisili.value = namaKecamatanKTP.value;
            namaKecamatanDomisili.setAttribute('readonly', '');

        }else if( dome == 1){
            cekbox.setAttribute('value', 0);

            namaJalanDomisili.value = "";
            rtDomisili.value = "";
            rwDomisili.value = "";
            namaDesaDomisili.value = "";
            namaKecamatanDomisili.value = "";

            namaJalanDomisili.removeAttribute('readonly');
            rtDomisili.removeAttribute('readonly');
            rwDomisili.removeAttribute('readonly');
            namaDesaDomisili.removeAttribute('readonly');
            namaKecamatanDomisili.removeAttribute('readonly');
        }
    });


    let cekalamat = document.getElementById('alamat-ortu-sama');
    let namaJalanDomisiliOrtu = document.getElementById('nama_jalan_ortu');
    let rtDomisiliOrtu = document.getElementById('rt_ortu');
    let rwDomisiliOrtu = document.getElementById('rw_ortu');
    let namaDesaDomisiliOrtu = document.getElementById('nama_desa_ortu');
    let namaKecamatanDomisiliOrtu = document.getElementById('nama_kecamatan_ortu');

    cekalamat.addEventListener('change', function(){

        let ditekan = cekalamat.getAttribute('value');
        if( ditekan == 0 ){

            cekalamat.setAttribute('value', 1);
            namaJalanDomisiliOrtu.value = namaJalanDomisili.value;
            rtDomisiliOrtu.value = rtDomisili.value;
            rwDomisiliOrtu.value = rwDomisili.value;
            namaDesaDomisiliOrtu.value = namaDesaDomisili.value;
            namaKecamatanDomisiliOrtu.value = namaKecamatanDomisili.value;

            namaJalanDomisiliOrtu.setAttribute('readonly', '');
            rtDomisiliOrtu.setAttribute('readonly', '');
            rwDomisiliOrtu.setAttribute('readonly', '');
            namaDesaDomisiliOrtu.setAttribute('readonly', '');
            namaKecamatanDomisiliOrtu.setAttribute('readonly', '');
        }else if( ditekan == 1 ){

            cekalamat.setAttribute('value', 0);

            namaJalanDomisiliOrtu.value = "";
            rtDomisiliOrtu.value = "";
            rwDomisiliOrtu.value = "";
            namaDesaDomisiliOrtu.value = "";
            namaKecamatanDomisiliOrtu.value = "";

            namaJalanDomisiliOrtu.removeAttribute('readonly');
            rtDomisiliOrtu.removeAttribute('readonly');
            rwDomisiliOrtu.removeAttribute('readonly');
            namaDesaDomisiliOrtu.removeAttribute('readonly');
            namaKecamatanDomisiliOrtu.removeAttribute('readonly');

        }
    });


    
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