@extends('Dashboard.Layouts.main')
@section('container')

<div id="container" class="container bg-dark">
    <div class="row g-0 mt-4">
        <div id="leftSideBar" class="text-bg-dark text-center">
            @if( $student->picture )
            <img src="{{ asset('Storage/' . $student->picture) }}" alt="tes" class="img-thumbnail text-center mt-5 mb-3" style="border-radius: 50%; margin: 0px auto;" width="80px;"> 
            @else
            <img src="/img/img-no-exist.jpg" alt="tes" class="img-thumbnail text-center mt-5 mb-3" style="border-radius: 50%; margin: 0px auto;" width="80px;"> 
            @endif

            <h6 class="">{{ $student->nama_panggilan_siswa }}</h6>   
            <h6 class="" style="margin-bottom: 70px; font-size: 10px;">{{ $student->email }}</h6>   
            <div class="nav flex-column" style="margin: 0px auto;">
                <a href="#" id="Information" class="nav-item text-decoration-none text-uppercase text-light fw-bold text-start mb-4">Dashboard</a>
                <a href="/data-siswa" class="nav-item text-decoration-none text-uppercase fw-bold text-start">Back</a>
            </div>
        </div>
        <div id="middleSideBar" class="p-4" style="border-radius: 20px; background-color: white;">
            <p type="button" id="closeTab" style="margin-left: 40px;"></p>
            <div id="modal-text" style="border-radius: 20px; margin-top: 30px;">
                <div style="width: 30%;" >
                    <h5 style="margin-top: 70px; margin-left: 50px; font-weight: bold;">Hey, {{ $student->nama_panggilan_siswa }}!</h5>
                    <p style="margin-left: 50px;">Nice to see you again. How's your day?</p>
                </div>
                <div style="width: 45%; text-align: center;">
                    <img src="/img/ilustration.jpg" alt="ilustration" width="300px" style="border-radius: 50px;">  
                </div>
            </div>
            <div class="container mt-5">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none text-muted" id="biodata" href="#"><i class="fa-solid fa-id-card mx-2"></i>Biodata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none text-muted" id="kontak" href="#"><i class="fa-solid fa-id-badge mx-2"></i>Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none text-muted" id="kelas" href="#"><i class="fa-solid fa-book mx-2"></i>Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none text-muted" id="pembayaran" href="#"><i class="fa-solid fa-receipt mx-2"></i>Pembayaran</a>
                    </li>
                </ul>
                <div id="biodataTab">
                    <p class="text-uppercase text-muted mt-5" id="biodata" style="letter-spacing: 1px;">BIODATA PRIBADI</p>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Nama Lengkap</div>
                        <div class="col-sm-6">: {{ $student->nama_siswa }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Nama Panggilan</div>
                        <div class="col-sm-6">: {{ $student->nama_panggilan_siswa }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Jenis Kelamin</div>
                        <div class="col-sm-6">: {{ $student->jenis_kelamin }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Tempat / Tanggal Lahir</div>
                        <div class="col-sm-6">: {{ $student->tempat_lahir }} / {{ $student->tanggal_lahir }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Agama</div>
                        <div class="col-sm-6">: {{ $student->agama }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Alamat Lengkap Domisili</div>
                        <div class="col-sm-6">: {{ $student->nama_jalan_domisili }}, RT{{ $student->rt_domisili }}/RW{{ $student->rw_domisili }}, Desa {{ $student->nama_desa_domisili }}, Kecamatan {{ $student->nama_kecamatan_domisili }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Tempat Tinggal</div>
                        <div class="col-sm-6">: {{ $student->tempat_tinggal }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Mode Transportasi Ke Sekolah</div>
                        <div class="col-sm-6">: {{ $student->transportasi }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Asal Sekolah</div>
                        <div class="col-sm-6 text-uppercase">: {{ $student->asal_sekolah }}, {{ $student->kota_asal_sekolah }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Tinggi Badan</div>
                        <div class="col-sm-6 text-uppercase">: {{ $student->tinggi_badan }} CM</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Jarak Tempuh Ke Sekolah</div>
                        <div class="col-sm-6 text-uppercase">: {{ $student->jarak_tempuh_sekolah }} KM</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Anak Ke</div>
                        <div class="col-sm-6">: {{ $student->urutan_anak }} Dari {{ $student->jumlah_saudara }} Bersaudara</div>
                    </div>
                </div>
                <div id="kontakTab">
                    <p class="text-uppercase text-muted mt-5" id="kontak" style="letter-spacing: 1px;">INFORMASI KOTAK</p>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">No Hp / Telp</div>
                        <div class="col-sm-6">: {{ $student->no_hp }}</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Email</div>
                        <div class="col-sm-6">: {{ $student->email }}</div>
                    </div>
                </div>
                <div id="kelasTab">
                    <p class="text-uppercase text-muted mt-5" id="kelas" style="letter-spacing: 1px;">KELAS</p>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach( $aktivasis as $aktivasi )
                        <div class="col">
                            <div class="card">
                                <img src="/img/unsplash/{{ $aktivasi['picture'] }}.jpg" class="card-img-top" alt="img" height="50%">
                                <div class="card-img-overlay text-end">
                                    <p class="badge text-bg-primary">{{ $aktivasi['status'] }}</p>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted"><small>{{ $aktivasi['programs'] }} Program </small>|<small> {{ $aktivasi['materis'] }} Materi</small></p>
                                    <h5 class="card-title">{{ $aktivasi['namaAktivasi'] }}</h5>
                                    <p class="card-text text-muted"><small>By International Hospitality School</small></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div id="pembayaranTab">
                    <p class="text-uppercase text-muted mt-5" id="kelas" style="letter-spacing: 1px;">PEMBAYARAN</p>
                    <h6>hello world</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>

    let biodata = document.getElementById('biodata');
    let kontak = document.getElementById('kontak');
    let kelas = document.getElementById('kelas');
    let pembayaran = document.getElementById('pembayaran');
    biodata.classList.add('active');
    document.getElementById('biodataTab').style.display = '';
    document.getElementById('kontakTab').style.display = 'none';
    document.getElementById('kelasTab').style.display = 'none';
    document.getElementById('pembayaranTab').style.display = 'none';
    document.getElementById('container').style.height = '950px';

    biodata.addEventListener('click', function(event){

        let itActive = biodata.classList.contains('active');
        if( !itActive ){
            biodata.classList.add('active');
            kontak.classList.remove('active');
            kelas.classList.remove('active');
            pembayaran.classList.remove('active');
        }
        document.getElementById('biodataTab').style.display = '';
        document.getElementById('kontakTab').style.display = 'none';
        document.getElementById('kelasTab').style.display = 'none';
        document.getElementById('pembayaranTab').style.display = 'none';
        
        document.getElementById('container').style.height = '950px';
    });

    kontak.addEventListener('click', function(event){
        let itActive = kontak.classList.contains('active');
        if( !itActive ){
            kontak.classList.add('active');
            biodata.classList.remove('active');
            kelas.classList.remove('active');
            pembayaran.classList.remove('active');
        }
        document.getElementById('kontakTab').style.display = '';
        document.getElementById('biodataTab').style.display = 'none';
        document.getElementById('kelasTab').style.display = 'none';
        document.getElementById('pembayaranTab').style.display = 'none';
        
        // alert('tes');
        document.getElementById('container').style.height = '660px';
    });

    kelas.addEventListener('click', function(event){
        let itActive = kelas.classList.contains('active');
        if( !itActive ){
            kelas.classList.add('active');
            biodata.classList.remove('active');
            kontak.classList.remove('active');
            pembayaran.classList.remove('active');
        }
        document.getElementById('kontakTab').style.display = 'none';
        document.getElementById('biodataTab').style.display = 'none';
        document.getElementById('kelasTab').style.display = '';
        document.getElementById('pembayaranTab').style.display = 'none';
        
        // alert('tes');
        // document.getElementById('container').style.height = '660px';
    });

    pembayaran.addEventListener('click', function(event){
        let itActive = pembayaran.classList.contains('active');
        if( !itActive ){
            pembayaran.classList.add('active');
            biodata.classList.remove('active');
            kontak.classList.remove('active');
            kelas.classList.remove('active');
        }
        document.getElementById('kontakTab').style.display = 'none';
        document.getElementById('biodataTab').style.display = 'none';
        document.getElementById('kelasTab').style.display = 'none';
        document.getElementById('pembayaranTab').style.display = '';
        console.log('pembayaran');
    });




    let closeTab = document.getElementById('closeTab');
    let leftSideBar = document.getElementById('leftSideBar');
    let middleSideBar = document.getElementById('middleSideBar');

    closeTab.setAttribute('value', '0');
    closeTab.innerHTML = "<i class='fa-solid fa-circle-arrow-left mx-2 mt-5'></i>Close Tab";
    middleSideBar.classList.add('col-sm-10');
    leftSideBar.classList.add('col-sm-2');
    leftSideBar.classList.add('d-flex');
    leftSideBar.classList.add('justify-content-center');
    leftSideBar.classList.add('flex-column');

    closeTab.addEventListener('click', function(e){

        let value = closeTab.getAttribute('value');
        let itContains7 = middleSideBar.classList.contains('col-sm-10');
        let itContains9 = middleSideBar.classList.contains('col-sm-12');

        
        if( value == '0' ){
            
            closeTab.setAttribute('value', '1');
            closeTab.innerHTML = "<i class='fa-solid fa-circle-arrow-right mx-2 mt-5'></i>Open Tab";
            leftSideBar.classList.remove('d-flex');
            leftSideBar.classList.remove('justify-content-center');
            leftSideBar.classList.remove('flex-column');
            leftSideBar.style.display = 'none';

            
            
            if( itContains7 ){
                
                middleSideBar.classList.remove('col-sm-10');
                middleSideBar.classList.add('col-sm-12');
            }

        }else if( value == '1' ){

            closeTab.setAttribute('value', '0');
            closeTab.innerHTML = "<i class='fa-solid fa-circle-arrow-left mx-2 mt-5'></i>Close Tab";
            leftSideBar.style.display = '';
            leftSideBar.classList.add('d-flex');
            leftSideBar.classList.add('justify-content-center');
            leftSideBar.classList.add('flex-column');

            
            if( itContains9 ){
                
                middleSideBar.classList.remove('col-sm-12');
                middleSideBar.classList.add('col-sm-10');
            }
            
        }
        
        // alert(value);
        
    });


</script>
@endpush