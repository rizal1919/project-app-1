@extends('Dashboard.Layouts.main')

@section('container')
<div class="container mt-5 mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header p-5">
                <a href="/form-registrasi" class="text-decoration-none d-block"><i class="fa-solid fa-arrow-left mx-2"></i>Kembali</a>
                <div class="row g-2 my-2">
                    <div class="col-sm-6 p-3">
                        <div class="btn-group btn-group-lg mt-2">
                            <h1 class="btn btn-outline-secondary" id="pembayaran">Pembayaran</h1>
                            <h1 class="btn btn-outline-secondary" id="biodata">Biodata</h1>
                        </div>
                    </div>
                    <div class="col-sm-6 p-3 text-start">
                        <div class="card">
                            <div class="card-body">
                                <h4>Total Pembayaran : {{ $biayaAktivasi }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="whiteboard" style="margin-left: 10px;">
                    <div id="top" class="Pembayaran-head-atas card-body border border-1 mt-2 bg-white">
                        <div class="box-bagian-atas">
                            <div class="Pembayaran-bagian-atas">
                                <p class="fw-bold judul-atas">Total Terbayar</p>
                                <p class="tanggal text-secondary ">{{ $terakhirPembayaran }}</p>
                            </div>
                            <div class="Pembayaran-bagian-tengah">
                                <h2 class="d-inline">{{ $biayaTerbayar }} </h2><p class="badge text-bg-info">Paid</p>
                            </div>
                            <a href="#" class="text-decoration-none fw-bold">Lihat riwayat transaksi</a>
                        </div>
                        <div class="box-bagian-bawah">
                            <div class="Pembayaran-bagian-atas">
                                <p class="fw-bold judul-atas">Sisa Pembayaran</p>
                                <p class="tanggal text-secondary ">{{ $terakhirPembayaran }}</p>
                            </div>
                            <div class="Pembayaran-bagian-tengah">
                                <h2 class="d-inline">{{ $biayaSisaTagihan }} </h2><p class="badge text-bg-warning">Pending</p>
                            </div>
                            <a href="#" class="text-decoration-none fw-bold ">Lihat riwayat transaksi</a>
                        </div>
                    </div>
                    <div id="bottom">
                        <h5>Biodata Siswa</h5>
                        <ul>
                            <li>Nama Lengkap : {{ $siswa->nama_siswa }}</li>
                            <li>Alamat : {{ $siswa->nama_jalan_domisili }}, RT {{ $siswa->rt_domisili }}/RW {{ $siswa->rw_domisili }}, Desa {{ $siswa->nama_desa_domisili }}, Kecamatan {{ $siswa->nama_kecamatan_domisili }}</li>
                            <li>Tanggal Lahir : {{ $siswa->tanggal_lahir }}</li>
                            <li>Jenis Kelamin : {{ $siswa->jenis_kelamin }}</li>
                            <li>No KTP : {{ $siswa->ktp }}</li>
                            <li>No HP / Telepon : {{ $siswa->no_hp }}</li>
                            <li>Kelas Aktivasi : {{ $dataAktivasi->nama_aktivasi }}</li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div class="card-body">
            @if( session('PaymentSuccess') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('PaymentSuccess') }}</strong> membayar cicilan. Terima Kasih
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('PaymentFailed') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Maaf! Pembayaran <strong>{{ session('PaymentFailed') }}</strong> ditambahkan. Terima Kasih
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
                <table class="table table-hover table-responsive mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jenis Pembayaran</th>
                            <th>Tagihan</th>
                            <th>Terbayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $dataCicilan as $cicilan )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cicilan['Tanggal'] }}</td>
                                <td>{{ $cicilan['Nama Cicilan'] }}</td>
                                <td>{{ $cicilan['Tagihan'] }}</td>
                                <td>{{ $cicilan['Terbayar'] }}</td>
                                <td>{{ $cicilan['Status'] }}</td>
                                @if( $cicilan['Status'] === 'Lunas' )
                                    <td>
                                        <?php $idPembayaran = $cicilan['idCicilan']; ?>
                                        <a href="/cost-payment-store/{{ $idPembayaran }}" class="btn btn-primary btn-sm" hidden>Bayar</a>
                                    </td>
                                @else
                                    <td>
                                        <?php $idPembayaran = $cicilan['idCicilan']; ?>
                                        <a href="/cost-payment-store/{{ $idPembayaran }}" class="btn btn-primary btn-sm">Bayar</a>
                                    </td>
                                @endif
                            </tr>   
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>

    


    let pembayaran = document.getElementById('pembayaran');
    let biodata = document.getElementById('biodata');

    document.getElementById('bottom').style.display = 'none';
    document.getElementById('top').style.display = '';

    pembayaran.addEventListener('click', function(){
        
        document.getElementById('top').style.display = '';
        document.getElementById('bottom').style.display = 'none';
        console.log('pembayaran clicked');
    });

    biodata.addEventListener('click', function(){
        document.getElementById('top').style.display = 'none';
        document.getElementById('bottom').style.display = '';
        console.log('biodata clicked');
    });
   
</script>
@endpush