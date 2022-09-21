@extends('Dashboard.Layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Halaman Tambah Guru</h1>
</div>
<div class="container d-flex justify-content-center">
    <div class="col-5">
        <div class="card">
            <form action="/teacher-create" method="post">
                @csrf
                <div class="card-header">
                    <h4>Tambah Guru</h4>
                </div>
                <div class="card-body">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control @error('teacher_name') is-invalid @enderror" id="teacher_name" name="teacher_name" placeholder="teacher_name" value="{{ old('teacher_name') }}" required autofocus>
                        <label for="teacher_name">Nama Guru</label>
                        @error('teacher_name')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="username" value="{{ old('username') }}" required>
                        <label for="username">Username</label>
                        @error('username')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="password" value="{{ old('password') }}" required>
                        <label for="password">Password</label>
                        @error('password')
                        <div class="invalid-feedback">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                        
                    </div>
                    <div class="form-text">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="passwordCek">
                            <label for="passwordCek" class="form-check-label">Lihat Password</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-primary mx-1"><i class="fas fa-database mx-2"></i>Tambah Data Guru</button>
                    <a href="/teacher" class="text-decoration-none btn btn-primary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    let pass = document.getElementById('passwordCek');
    pass.setAttribute('value', 0);
    pass.addEventListener('change', function(e){

        val = pass.getAttribute('value');

        if(val == 0){

            document.getElementById('password').setAttribute('type', 'text');
            pass.setAttribute('value', '1');
        }else if(val == 1){
            
            document.getElementById('password').setAttribute('type', 'password');
            pass.setAttribute('value', '0');
        }
        
    });
</script>

@endpush