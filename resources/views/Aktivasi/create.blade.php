@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman {{ $active }}</h1>
</div>
    <div class="container d-flex justify-content-center my-4">
        <div class="card col-lg-12 d-flex justify-content-center">
            @if( session('pendaftaranGagal') )
            <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
                Informasi data <strong>{{ session('pendaftaranGagal') }}</strong> paket pilihan harus dipilih.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if( session('sukses') )
            <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                Informasi data <strong>{{ session('sukses') }}</strong> telah teraktivasi.
                <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-header">
                <p class="card-title">
                    Form Aktivasi
                </p>
            </div>
            
            <form action="/create-aktivasi" method="post">
                @csrf
                
                    <div class="row mb-3 mt-5 text-start d-flex justify-content-center">
                        <div class="col-sm-3">
                            <label for="nama_aktivasi" class="col-form-label col-form-label-sm fw-bold">Nama Aktivasi</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" name="nama_aktivasi" id="nama_aktivasi" class="form-control form-control-sm @error('nama_aktivasi') is-invalid @enderror" value="{{ old('nama_aktivasi') }}" placeholder="Sukses Akuntansi" autofocus required>
                            @error('nama_aktivasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 text-start d-flex justify-content-center">
                        <div class="col-sm-3">
                            <label for="biaya" class="col-form-label col-form-label-sm fw-bold">Biaya</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="number" name="biaya" id="biaya" class="form-control form-control-sm @error('biaya') is-invalid @enderror" value="{{ old('biaya') }}" placeholder="4500000" required>
                            @error('biaya')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3 text-start d-flex justify-content-center">
                        <div class="col-sm-3">
                            <label for="Periode_Pendafataran" class="col-form-label col-form-label-sm fw-bold">Periode </label>
                        </div>
                        <div class="col-sm-1">
                            <label for="Periode_Pendafataran" class="col-form-label col-form-label-sm fw-bold">Pembukaan</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="date" name="pembukaan" value="{{ old('pembukaan') }}" id="Periode_Pendaftaran" class="form-control form-control-sm">
                        </div>
                        <div class="col-sm-1 text-center">
                            <label for="Periode_Pendafataran" class="col-form-label col-form-label-sm fw-bold">-</label>
                        </div>
                        <div class="col-sm-1">
                            <label for="Periode_Pendafataran" class="col-form-label col-form-label-sm fw-bold">Penutupan</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="date" name="penutupan" id="Periode_Pendaftaran" value="{{ old('penutupan') }}" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row g-3 text-start mb-5 d-flex justify-content-center">
                        <div class="col-sm-3">
                            <label for="program_id" class="col-form-label col-form-label-sm fw-bold">Program Pilihan</label>
                        </div>
                        <div class="col-sm-7">
                            <p class="fw-bold">Daftar Program Tersedia</p>
                            <div class="form-check" id="checkbox">
                                @foreach ( $programs as $program )
                                    <input type="checkbox" class="form-check-input" name="program_id_{{ $program->id }}" id="program_id_{{ $program->id }}" value="{{ $program->id }}">
                                    <label for="program_id_{{ $program->id }}" class="form-check-label">{{ $program->nama_program }}</label><br>
                                @endforeach
                            </div>
                        </div>
                       
                    </div>
                    
                    <div class="row d-flex justify-content-end mx-3 mt-3">
                        <div class="col-6 p-2 d-flex justify-content-center align-items-end">
                            <p><em><small>Pastikan semua data terisi dengan benar sebelum menekan tombol submit data.</small></em></p>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary"><i class="fa-solid fa-database mx-2"></i>Tambah Paket Aktivasi</button>
                            <a href="/aktivasi" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>


@endsection


@push('js')

<script>
    $(document).ready(function(){
        $('#category_id').on('change', function(){

            var value = $('#category_id').val();
            $.ajax({
                url:"{{ route('cariProgram') }}",
                type:"GET",
                data:{'id':value},
                success: function(data){
                    console.log(data);
                    $('#checkbox').html(data);   

                    
                }
            });
        });
    });

    function changeStyle(){
        var element = document.getElementById("hide");
        element.style.display = "none";
    }
    
</script>
@endpush