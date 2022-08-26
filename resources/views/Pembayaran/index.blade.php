@extends('Dashboard.Layouts.main')

@section('container')
<div class="container mt-2 mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header p-5">
                <div class="card-title ">
                    <h3>Pembayaran</h3>
                </div>
                <div class="btn-group btn-group-sm mt-1">
                    <button class="pembayaran btn btn-outline-primary fw-bold">{{ $nama_siswa }}</button>
                    <button class="btn btn-outline-primary fw-bold">{{ $nama_program }}</button>
                </div>
                <div class="Pembayaran-head-atas card-body border border-1 mt-2 bg-white">
                    <div class="box-bagian-atas">
                        <div class="Pembayaran-bagian-atas">
                            <p class="fw-bold judul-atas">Total Terbayar</p>
                            <p class="tanggal text-secondary ">{{ $tanggal }}</p>
                        </div>
                        <div class="Pembayaran-bagian-tengah">
                            <h2 class="d-inline">{{ $totalTerbayar }} </h2><p class="badge text-bg-info">Paid</p>
                        </div>
                        <a href="#" class="text-decoration-none fw-bold">Lihat riwayat transaksi</a>
                    </div>
                    <div class="box-bagian-bawah">
                        <div class="Pembayaran-bagian-atas">
                            <p class="fw-bold judul-atas">Sisa Pembayaran</p>
                            <p class="tanggal text-secondary ">{{ $tanggal }}</p>
                        </div>
                        <div class="Pembayaran-bagian-tengah">
                            <h2 class="d-inline">{{ $sisaPembayaran }} </h2><p class="badge text-bg-warning">Pending</p>
                        </div>
                        <a href="#" class="text-decoration-none fw-bold ">Lihat riwayat transaksi</a>
                    </div>
                </div>
               
            </div>
            <div class="card-body">
            @if( session('tambahCicilan') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Cicilan sebesar <strong>{{ session('tambahCicilan') }}</strong> telah berhasil dibayarkan. Terima Kasih
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('gagalCicilan') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Cicilan sebesar <strong>{{ session('gagalCicilan') }}</strong> gagal ditambahkan karena jumlah cicilan melebihi total tagihan. Terima Kasih
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 d-flex mt-4 justify-content-start">
                        @if( $sisaPembayaran == "Rp0,00" )
                            <a href="/cost-payment/{{ $id }}/{{ $nama_program }}" class="btn btn-secondary disabled mx-1" style="width: 20%; height: 100%;" >Telah Dilunasi</a>
                        @else
                            <a href="/cost-payment/{{ $id }}/{{ $nama_program }}" class="btn btn-primary mx-1" style="width: 20%; height: 100%;" >Bayar Cicilan</a>
                        @endif
                        <form action="/form-registrasi" method="get" class="mx-2" style="width: 70%;" >
                            @csrf
                            <div class="input-group">
                                <input type="text" name="nama_siswa" value="" class="form-control text-end" placeholder="Nama">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
                        <a href="/form-registrasi" class="btn btn-primary mx-1" style="width: 10%; height: 100%;">Kembali</a>
                    </div>
                </div>
                <table class="table table-hover table-responsive mt-3">
                    <thead>
                        <tr>
                            <th>Cicilan</th>
                            <th>Tanggal</th>
                            <th>Dibayar</th>
                            <th>Total Tagihan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $payments as $pay )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pay['tanggal'] }}</td>
                                <td>{{ $pay['totalTerbayar'] }}</td>
                                <td>{{ $pay['sisaTagihan'] }}</td>
                                <td><p class="badge text-bg-info">{{ $pay['status'] }}</p></td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection