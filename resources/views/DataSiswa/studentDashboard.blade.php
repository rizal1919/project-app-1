@extends('Layouts.main')
@section('content')

<div id="container" class="container bg-dark">
    <div class="row g-0 mt-4">
        <div id="leftSideBar" class="text-bg-dark text-center">
            <img src="/img/photo-profile.png" alt="tes" class="img-thumbnail text-center mt-5 mb-3" style="border-radius: 50%; margin: 0px auto;" width="80px;"> 
            <h6 class="">Rizal</h6>   
            <h6 class="" style="margin-bottom: 70px; font-size: 10px;">hirizal01@gmail.com</h6>   
            <div class="nav flex-column" style="margin: 0px auto;">
                <a href="#" class="nav-item text-decoration-none text-uppercase text-muted fw-bold text-start mb-4">Information</a>
                <a href="#" class="nav-item text-decoration-none text-uppercase text-muted fw-bold text-start mb-4">Dashboard</a>
                <a href="#" class="nav-item text-decoration-none text-uppercase text-muted fw-bold text-start mb-4">Payments</a>
                <a href="/data-siswa" class="nav-item text-decoration-none text-uppercase text-muted fw-bold text-start">Back</a>
            </div>
        </div>
        <div id="middleSideBar" class="p-4" style="border-radius: 20px; background-color: white;">
            <p type="button" id="closeTab" style="margin-left: 40px;"></p>
            <div id="modal-text" style="border-radius: 20px; margin-top: 30px;">
                <div style="width: 50%;">
                    <h5 style="margin-top: 110px; font-weight: bold;">Hey, Rizal!</h5>
                    <p>Nice to see you again</p>
                </div>
                <div style="width: 40%;">
                    <img src="/img/ilustration.jpg" alt="ilustration" width="390px" style="border-radius: 50px;">  
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
                </ul>
                <div id="biodataTab">
                    <p class="text-uppercase text-muted mt-5" id="biodata" style="letter-spacing: 1px;">BIODATA</p>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Nama Lengkap</div>
                        <div class="col-sm-6">: Rizal Fathurrahman</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Nama Panggilan</div>
                        <div class="col-sm-6">: Rizal</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Jenis Kelamin</div>
                        <div class="col-sm-6">: Laki-laki</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Tempat / Tanggal Lahir</div>
                        <div class="col-sm-6">: Gresik / 19 Jun 1999</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Agama</div>
                        <div class="col-sm-6">: Islam</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Alamat Lengkap Domisili</div>
                        <div class="col-sm-6">: Jalan Raya Cangkir, RT14/RW05, Desa Cangkir, Kecamatan Driyorejo</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Tempat Tinggal</div>
                        <div class="col-sm-6">: Bersama Orang Tua</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Mode Transportasi Ke Sekolah</div>
                        <div class="col-sm-6">: Kendaraan Pribadi</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Asal Sekolah</div>
                        <div class="col-sm-6 text-uppercase">: SMAN 1 DRIYOREJO, gresik</div>
                    </div>
                </div>
                <div id="kontakTab">
                    <p class="text-uppercase text-muted mt-5" id="kontak" style="letter-spacing: 1px;">INFORMASI KOTAK</p>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">No Hp / Telp</div>
                        <div class="col-sm-6">: 085733721962</div>
                    </div>
                    <div class="row g-1 my-3">
                        <div class="col-sm-4">Email</div>
                        <div class="col-sm-6">: hirizal01@gmail.com</div>
                    </div>
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
    biodata.classList.add('active');
    document.getElementById('biodataTab').style.display = '';
    document.getElementById('kontakTab').style.display = 'none';
    document.getElementById('container').style.height = '1020px';

    biodata.addEventListener('click', function(event){

        let itActive = biodata.classList.contains('active');
        if( !itActive ){
            biodata.classList.add('active');
            kontak.classList.remove('active');
        }
        document.getElementById('biodataTab').style.display = '';
        document.getElementById('kontakTab').style.display = 'none';
        
        document.getElementById('container').style.height = '1020px';
    });
    kontak.addEventListener('click', function(event){
        let itActive = kontak.classList.contains('active');
        if( !itActive ){
            kontak.classList.add('active');
            biodata.classList.remove('active');
        }
        document.getElementById('biodataTab').style.display = 'none';
        document.getElementById('kontakTab').style.display = '';
        
        document.getElementById('container').style.height = '720px';
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