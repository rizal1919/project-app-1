@extends('Dashboard.Layouts.main')

@section('container')
<div class="container mt-5">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header p-5">
                <div class="card-title ">
                    <h3>Pembayaran</h3>
                </div>
                <div class="btn-group btn-group-sm mt-1">
                    <button class="pembayaran btn btn-outline-primary">Rizal Fathurrahman </button>
                    <button class="btn btn-outline-primary"> Reguler - Teknik Informatika</button>
                </div>
                <div class="Pembayaran-head-atas card-body border border-1 mt-2 bg-white">
                    <div class="box-bagian-atas">
                        <div class="Pembayaran-bagian-atas">
                            <p class="fw-bold judul-atas">Total Terbayar</p>
                            <p class="tanggal text-secondary ">Apr 12, 2022</p>
                        </div>
                        <div class="Pembayaran-bagian-tengah">
                            <h2 class="d-inline">Rp1.250.500,00 </h2><p class="badge text-bg-info">Paid</p>
                        </div>
                        <a href="#" class="text-decoration-none fw-bold">Lihat riwayat transaksi</a>
                    </div>
                    <div class="box-bagian-bawah">
                        <div class="Pembayaran-bagian-atas">
                            <p class="fw-bold judul-atas">Sisa Pembayaran</p>
                            <p class="tanggal text-secondary ">Apr 12, 2022</p>
                        </div>
                        <div class="Pembayaran-bagian-tengah">
                            <h2 class="d-inline">Rp850.500,00 </h2><p class="badge text-bg-warning">Pending</p>
                        </div>
                        <a href="#" class="text-decoration-none fw-bold ">Lihat riwayat transaksi</a>
                    </div>
                </div>
               
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 d-flex mt-4 justify-content-start">
                        <a href="/form-registrasi" class="btn btn-primary mx-1" style="width: 10%; height: 100%;">Kembali</a>
                        <a href="#" class="btn btn-primary mx-1" style="width: 20%; height: 100%;">Bayar Cicilan</a>
                        <form action="/form-registrasi" method="get" class="mx-2" style="width: 70%;" >
                            @csrf
                            <div class="input-group">
                                <input type="text" name="nama_siswa" value="" class="form-control text-end" placeholder="Nama">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
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
                        <tr>
                            <td>1</td>
                            <td>12 June 2022</td>
                            <td>Rp250.000,00</td>
                            <td>Rp1.250.000,00</td>
                            <td><p class="badge text-bg-info">lunas</p></td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection