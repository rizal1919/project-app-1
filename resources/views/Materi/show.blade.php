
@extends('layouts.main')

@section('content')

<div class="container-lg">
    <div class="row justify-content-center" style="margin-top: 120px;">
        <div class="col-lg-5" style="height: 30%;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">ACADEMY</h5>
                </div>
                <div class="card-body">
                    <?php $i=0; ?>
                    @foreach( $dataMateri->materi as $t )
                        @if( $t['id'] === $id )
                        
                        <p class="card-text">ID : {{ $t->id }}</p>
                        <p class="card-text">Program : {{ $dataMateri->nama_program }}</p>
                        <p class="card-text">Nama Materi : {{ $t->nama_materi }}</p>
                        <p class="card-text">Dibuat : {{ $t->created_at->diffForHumans() }}</p>
                        @endif
                        <?php $i++; ?>
                    @endforeach
                </div>
                <button class="btn btn-primary mt-3 rounded-bottom" style="border-radius: 0px;">
                    <a href="/materi/{{ $dataMateri->id }}" class="text-decoration-none" style="color: white;">Kembali</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection