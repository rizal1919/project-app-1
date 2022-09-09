@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Form Pembayaran</h1>
</div>
<div class="container d-flex justify-content-center mt-5">
    <div class="col-lg-6">
        <form action="/cost-payment-store/{{ $data->student_id }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header bg-primary">
                    <p class="card-text text-light fw-bold">Form Pembayaran</p>
                </div>
                <div class="card-body p-4">
                    <div class="col-auto">
                        <div class="form-floating mt-3">
                            <input type="hidden" name="idCicilan" value="{{ $data->id }}">
                            <input type="number" value="{{ old('biaya', $data->installment) }}" name="biaya" class="form-control" id="biaya" placeholder="Jumlah Cicilan" autofocus required>
                            <label for="biaya">Cicilan</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary text-end">
                    <a href="/cost/{{ $data->student_id }}" class="btn btn-light text-primary fw-bold">Kembali</a>
                    <button class="btn btn-light text-primary fw-bold"><i class="fa-solid fa-database mx-2"></i>Bayar Cicilan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection