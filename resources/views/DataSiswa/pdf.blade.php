<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>

        .container{
            margin-top: 10px;
            height: 1000px;
        }
        .head{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        .foot{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }


        .list-1{
            font-size: 10px;
        }

    </style>

</head>
<body>
    <div class="container col-lg-7">
        <div class="head text-center">
            <div class="col-lg-8" id="bagian-icon">
                <img src="/img/master-icon.jpg" class="img-fluid" alt="Web Icon" width="180px" height="100px"> 
                <h6>FORMULIR PENDAFTARAN & PENERIMAAN PESERTA DIDIK</h6>
                <h6>LKP IHS ADHIKARI SURABAYA</h6>
                <h6>TAHUN AJARAN 2022 - 2023</h6>
            </div>
            <div class="col-lg-3" style="width: 150px;">
                <div class="card border border-0">
                    <div class="card-body border border-0" style="height: 170px;">
                        @if( $student->picture )
                            <img src="{{ asset('Storage/' . $student->picture) }}" alt="photo-profile" style="border-radius: 10px;" width="140px" height="150px">
                        @else
                            <img src="/img/img-no-exist.jpg" alt="photo-profile" style="border-radius: 10px;" width="140px" height="150px">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content mt-1" style="margin-left: 30px;">
            <h6 style="font-size: 13px;" class="fw-bold">A. KETERANGAN CALON PESERTA DIDIK</h6>
            <ol class="list-1">
                <li class="">Nama Lengkap<p class="d-inline" style="margin-left: 75px;">: </p>{{ $student->nama_siswa }}</li>
                <li class="">Nama Panggilan<p class="d-inline" style="margin-left: 69px;">: </p>{{ $student->nama_panggilan_siswa }}</li>
                <li class="">Jenis kelamin<p class="d-inline" style="margin-left: 83px;">: </p>{{ $student->jenis_kelamin }}</li>
                <li class="">Tempat / Tanggal Lahir<p class="d-inline" style="margin-left: 41px;">: </p>{{ $student->tempat_lahir }} / {{ $student->tanggal_lahir }}</li>
                <li class="">Agama<p class="d-inline" style="margin-left: 110px;">: {{ $student->agama }}</p></li>
                <li class="">Alamat Lengkap (Sesuai KTP)<p class="d-inline" style="margin-left: 14px;">: Jl </p>{{ $student->nama_jalan_ktp }}<p class="d-inline" style="margin-left: 14px;">RT/RW : </p>{{ $student->rt_ktp }}/{{ $student->rw_ktp }}</li>
                <li class="" style="list-style-type: none;"><p class="d-inline" style="margin-left: 142px; ">: Desa/Kel </p>{{ $student->nama_desa_ktp }}<p class="d-inline" style="margin-left: 14px;">Kec : </p>{{ $student->nama_kecamatan_ktp }}</li>
                <li class="">Alamat Lengkap (Domisili)<p class="d-inline" style="margin-left: 26px;">: Jl </p>{{ $student->nama_jalan_domisili }}<p class="d-inline" style="margin-left: 14px;">RT/RW : </p>{{ $student->rt_domisili }}/{{ $student->rw_domisili }}</li>
                <li class="" style="list-style-type: none;"><p class="d-inline" style="margin-left: 142px; ">: Desa/Kel </p>{{ $student->nama_desa_domisili }}<p class="d-inline" style="margin-left: 14px;">Kec : </p>{{ $student->nama_kecamatan_domisili }}</li>
                <li class="">Tempat Tinggal<p class="d-inline" style="margin-left: 74px;">: </p>{{ $student->tempat_tinggal }}</li>
                <li class="">Mode Transportasi Ke Sekolah<p class="d-inline" style="margin-left: 10px;">: </p>{{ $student->transportasi }}</li>
                <li class="">No Telp / Hp (masih aktif)<p class="d-inline" style="margin-left: 29px;">: </p>{{ $student->no_hp }}</li>
                <li class="">Asal Sekolah<p class="d-inline" style="margin-left: 87px;">: </p>{{ $student->asal_sekolah }} <p class="d-inline" style="margin-left: 10px;">Kota</p> {{ $student->kota_asal_sekolah }}</li>
            </ol>
            <h6 style="font-size: 13px;" class="fw-bold">B. KETERANGAN ORANG TUA KANDUNG PESERTA DIDIK</h6>
            <ol class="list-1">
                <li class="fw-bold">Nama Lengkap</li>
                <li class="" style="list-style-type: none;">a. Ayah<p class="d-inline" style="margin-left: 109px;">: </p>{{ $student->nama_ayah }}</li>
                <li class="" style="list-style-type: none;">a. Ibu<p class="d-inline" style="margin-left: 117px;">: </p>{{ $student->nama_ibu }}</li>
                <li class="fw-bold">Tahun Lahir</li>
                <li class="" style="list-style-type: none;">a. Ayah<p class="d-inline" style="margin-left: 109px;">: </p>{{ $tahun_lahir_ayah }}</li>
                <li class="" style="list-style-type: none;">a. Ibu<p class="d-inline" style="margin-left: 117px;">: </p>{{ $tahun_lahir_ibu }}</li>
                <li class="fw-bold">Pendidikan Terakhir</li>
                <li class="" style="list-style-type: none;">a. Ayah<p class="d-inline" style="margin-left: 109px;">: </p>{{ $student->pendidikan_ayah }}</li>
                <li class="" style="list-style-type: none;">a. Ibu<p class="d-inline" style="margin-left: 117px;">: </p>{{ $student->pendidikan_ibu }}</li>
                <li class="fw-bold">Pekerjaan</li>
                <li class="" style="list-style-type: none;">a. Ayah<p class="d-inline" style="margin-left: 109px;">: </p>{{ $student->pekerjaan_ayah }}</li>
                <li class="" style="list-style-type: none;">a. Ibu<p class="d-inline" style="margin-left: 117px;">: </p>{{ $student->pekerjaan_ibu }}</li>
                <li class="fw-bold">Penghasilan Gaji Rata-Rata Perbulan</li>
                <li class="" style="list-style-type: none;">a. Ayah<p class="d-inline" style="margin-left: 109px;">: </p>{{ $penghasilan_ayah }}</li>
                <li class="" style="list-style-type: none;">a. Ibu<p class="d-inline" style="margin-left: 117px;">: </p>{{ $penghasilan_ibu }}</li>
                <li class="fw-bold">Keterangan</li>
                <li class="" style="list-style-type: none;">a. Ayah<p class="d-inline" style="margin-left: 109px;">: </p>{{ $student->keterangan_ayah }}</li>
                <li class="" style="list-style-type: none;">a. Ibu<p class="d-inline" style="margin-left: 117px;">: </p>{{ $student->keterangan_ibu }}</li>

                <li class=""><strong>Lengkap Tinggal</strong><p class="d-inline" style="margin-left: 63px;">: Jl </p>{{ $student->nama_jalan_ortu }}<p class="d-inline" style="margin-left: 14px;">RT/RW : </p>{{ $student->rt_ortu }}/{{ $student->rw_ortu }}</li>
                <li class="" style="list-style-type: none;"><p class="d-inline" style="margin-left: 142px; ">: Desa/Kel </p>{{ $student->nama_desa_ortu }}<p class="d-inline" style="margin-left: 14px;">Kec : </p>{{ $student->nama_kecamatan_ortu }}</li>
            </ol>
            <h6 style="font-size: 13px;" class="fw-bold">C. DATA PERIODIK CALON PESERTA DIDIK</h6>
            <ol class="list-1">
                <li class="">Tinggi Badan<p class="d-inline" style="margin-left: 86px;">: </p>{{ $student->tinggi_badan }} CM</li>
                <li class="">Jarak Rumah Ke Sekolah<p class="d-inline" style="margin-left: 37px;">: </p>{{ $student->jarak_tempuh_sekolah }} KM</li>
                <li class="">Anak Ke<p class="d-inline" style="margin-left: 108px;">: </p>{{ $student->urutan_anak }} Dari {{ $student->jumlah_saudara }}</li>
            </ol>
            <p class="list-1" style="width: 95%;">Sesuai dengan apa yang saya dapat dari informasi Lembaga LKP IHS Adhikari ini Saya sangat tertarik untuk menjadi Peserta Didik Tahun Ajaran 2022 - 2023 dengan pilihan :</p>
            <div class="foot">
                <div class="col-lg-6">
                    <h6 style="font-size: 13px;" class="fw-bold">Lingkari Yang Dipilih</h6>
                    <ol class="list-1">
                        @foreach( $aktivasis as $aktivasi )
                            <li>{{ $aktivasi->nama_aktivasi }}</li>
                        @endforeach
                    </ol>
                    <h6 style="font-size: 13px;" class="fw-bold">Pola Pembayaran Pendidikan</h6>
                    <ol class="list-1">
                        <li>Lunas (Free Seragam)</li>
                        <li>Dicicil</li>
                    </ol>
                </div>
                <div class="col-lg-6 text-center" style="width: 40%;">
                    <h6 style="font-size: 13px;" class="fw-bold mb-5">Tanda Tangan Siswa</h6>
                    <!-- <p>(...................................)</p> -->
                    <p style="font-size: 13px;" class="fw-bold">{{ $student->nama_siswa }}</p>
                </div>
            </div>
        </div>


    </div>
    
    <script>
        window.print();
    </script>
</body>
</html>

