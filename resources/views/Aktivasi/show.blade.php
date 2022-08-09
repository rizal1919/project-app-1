@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY - SHORTCOURSE</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">ID : 1</p>
                    <p class="card-text">Nama Program : Lorem</p>
                    <p class="card-text">Harga : Rp.400.000,00</p>
                    <p class="card-text">Periode : 2022</p>
                    <p class="card-text">Dibuat : 5 minutes ago</p>
                </div>
                <button class="btn btn-primary mt-3 rounded-bottom" style="border-radius: 0px;">
                    <a href="/aktivasi" class="text-decoration-none" style="color: white;">Kembali</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection