@extends('Layouts.main')

@include('Layouts.Navbar.navbar')
@section('content')
<div class="container text-center my-3">
    <h1>All Classes</h1>
</div>
<div class="container-lg">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-10 d-flex justify-content-center text-center">
            <form action="/kelas-admin" method="post" class="" style="width: 100%; display:inline-block;">
                @csrf
                <input type="text" id="search" name="search" class="form-control d-inline" style="width: 80%;" placeholder="Search">
                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
            </form>
        </div>
    </div>
</div>
<div class="container p-4 d-flex justify-content-center">
    <div class="row d-flex justify-content-center">
        <div class="col-10 d-flex flex-row flex-wrap justify-content-center">
            @foreach( $programs as $program )
                <div class="card mx-3 my-3" style="width: 30%;">
                    <img src="https://source.unsplash.com/300x300?{{ $category[mt_rand(0,6)] }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $program->nama_program }}</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                    <div class="card-body text-end">
                        <a href="/kelas-admin/show/{{ $program->id }}" class="btn btn-primary">Lihat Kelas</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-8 mt-2 mb-5">
            {{ $programs->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>



@endsection