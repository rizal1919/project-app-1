
@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Kurikulum</h1>
</div>
<div class="container-lg mt-5">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY - KURIKULUM</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>ID :</strong> {{ $kurikulums->id }}</p>
                    <p class="card-text"><strong>Nama Kurikulum :</strong> {{ $kurikulums->nama_kurikulum }}</p>
                    <p class="card-text"><strong>Biaya :</strong> {{ $kurikulums->biaya }}</p>
                    <p class="card-text"><strong>Dibuat :</strong> {{ $kurikulums->created_at->diffForHumans() }}</p>
                </div>
                
                <a href="/kurikulum" class="text-decoration-none btn btn-primary mt-3 rounded-bottom" style="color: white; border-radius: 0px;">Kembali</a>
                
            </div>
        </div>
    </div>
</div>
@endsection