@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12 d-flex justify-content-center text-center">
            <form action="/kelas-admin" method="post" class="" style="width: 100%; display:inline-block;">
                @csrf
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control d-inline" style="width: 90%;" placeholder="Search">
                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
            </form>
        </div>
    </div>
</div>
<div class="container p-4 d-flex justify-content-center">
    <div class="row d-flex justify-content-center">
        <div class="col-12 d-flex flex-row flex-wrap justify-content-center">
            @foreach( $kurikulums as $kurikulum )
                <div class="card mx-3 my-3" style="width: 30%;">
                    <img src="https://source.unsplash.com/300x300?{{ $category[mt_rand(0,6)] }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $kurikulum->nama_kurikulum }}</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                    <div class="card-body text-end">
                        <a href="/kelas-admin/show/{{ $kurikulum->id }}" class="btn btn-primary">Lihat Kelas</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-8 mt-2 mb-5">
            {{ $kurikulums->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>



@endsection