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
            @if( session('UpdateSuccess') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                <strong>{{ session('UpdateSuccess') }}</strong> mengubah tanggal pembayaran.
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
                                <?php $tagihan = $cicilan['Tagihan']; ?>
                                <?php $idPembayaran = $cicilan['idCicilan']; ?>
                                <?php $tanggalTagihan = $cicilan['Tanggal']; ?>
                                <td>{{ $loop->iteration }}</td>
                                @if( $cicilan['Status'] === 'Paid' )
                                <td>{{ $cicilan['Tanggal'] }}</td>
                                @else
                                <td>{{ $cicilan['Tanggal'] }}
                                    <button type="button" class="border border-0 bg-light" id="changeDate" data-url="/cost-payment-edit/" data-toggle="modal" data-bs-target="#staticBackdrop" onclick="changeDate('{{ $idPembayaran }}')"><i class="fa-regular fa-calendar mx-2"></i></button>
                                </td>
                                @endif
                                <td>{{ $cicilan['Nama Cicilan'] }}</td>
                                <td>{{ $cicilan['Tagihan'] }}</td>
                                <td>{{ $cicilan['Terbayar'] }}</td>
                                <td>{{ $cicilan['Status'] }}</td>
                                @if( $cicilan['Status'] === 'Paid' )
                                    <td>
                                        <a href="/cost-payment-store/{{ $idPembayaran }}" class="btn btn-primary btn-sm" hidden>Bayar</a>
                                    </td>
                                @else
                                    <td>
                                        <button id="delete" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-bs-target="#staticBackdrop" data-url="/cost-payment-store/" onclick="confirmation('{{ $idPembayaran }}', '{{ $tagihan }}', '{{ $tanggalTagihan }}')">Bayar</button>
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
<!-- Delete Warning Modal -->
<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" id="forms" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headlines">
                    <!-- <i class="fa-solid fa-money-bill-1 mx-2"></i>Tagihan Pembayaran -->
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" id="dateModal" name="date" class="form-control form-control-sm mb-3" style="width: 50%;">
                <h6 class="text-center mb-4" id="message3">Invoice Cicilan</h6>
                <p id="dateconfirmation"></p>
                <p id="message1"></p>
                <p class="mt-5" id="message2">Anda yakin ingin melanjutkan pembayaran cicilan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button type="submit" id="acceptanceModal" class="btn btn-primary">Bayar!</button>
            </div>
        </form>
    </div>
</div>
<!-- End Delete Modal --> 

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

    let headline = document.getElementById('headlines');
    let acceptanceModal = document.getElementById('acceptanceModal');
    let urlDelete = document.getElementById('delete').getAttribute('data-url');
    let urlChangeDate = document.getElementById('changeDate').getAttribute('data-url');
    let inputTanggal = document.getElementById('dateModal');
    let dateconfirmation = document.getElementById('dateconfirmation');
    let message1 = document.getElementById('message1');
    document.getElementById('message2').style.display = '';
    document.getElementById('message3').style.display = '';
    let completeUrl = '';

    function confirmation(idPembayaran, tagihan, tanggalPembayaran){

        
        completeUrl = urlDelete + idPembayaran;
        // output = delete-materi/1

        // element.classList.add("mystyle");

        // $('#name').val(delId);
        $('#forms').attr('action', completeUrl);
        message1.innerHTML = "> Total tagihan : <strong>" + tagihan + "? </strong>";

        inputTanggal.type = "hidden";
        document.getElementById('message3').style.display = '';
        document.getElementById('message2').style.display = '';
        headline.innerHTML = '<i class="fa-solid fa-money-bill-1 mx-2"></i>Tagihan Pembayaran';
        dateconfirmation.style.display = '';
        dateconfirmation.innerHTML = "<p>> Tanggal Pembayaran : <strong>" + tanggalPembayaran + " </strong></p>";
        acceptanceModal.innerText = 'Bayar!';

        $('#staticBackdrop').modal('show');
        // menampilkan modal box

    }

    function changeDate(idPembayaran){

        completeUrl = urlChangeDate + idPembayaran;

        $('#forms').attr('action', completeUrl);

        // document.getElementById('dateModal').classList.add("form-control");
        // document.getElementById('dateModal').classList.add("form-control-sm");
        inputTanggal.type = "date";

        headline.innerHTML = '<i class="fa-regular fa-calendar mx-2"></i>Ubah Tanggal Pembayaran';
        message1.innerHTML = 'Anda yakin ingin mengubah tanggal pembayaran tagihan ? ';
        dateconfirmation.style.display = 'none';
        document.getElementById('message2').style.display = 'none';
        document.getElementById('message3').style.display = 'none';
        acceptanceModal.innerText = 'Ubah Tanggal!';

        $('#staticBackdrop').modal('show');
        // alert('tes');

    }

    


    
   
</script>
@endpush