@extends('layouts.main')

@section('content')
    <div class="row justify-content-center mt-5 align-items-center" style='height: 500px;'>
        <div class="col-lg-4">
        <main class="form-registration w-100 m-auto">
        <form action="/register-admin" method="post">
            @csrf
            <h1 class="h3 mb-4 fw-normal text-center"></i>Form Registrasi Admin</h1>
            <div class="form-floating">
                <input type="text" name="name_admin" class="@error('name_admin') is-invalid @enderror form-control" id="name_admin" style="border-radius: 5px 5px 0px 0px; margin-bottom: -1px;" placeholder="Nama Lengkap" value="{{ old('name_admin') }}" required>
                <label for="name_admin">Nama Lengkap</label>
                @error('name_admin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="text" name="username_admin" class="@error('username_admin') is-invalid @enderror form-control" id="username_admin" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('username_admin') }}" placeholder="Username" required>
                <label for="username_admin">Username</label>
                @error('username_admin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" placeholder="email@example.com" style="border-radius: 0px 0px 0px 0px; margin-bottom: -1px;" value="{{ old('email') }}"  required>
                <label for="email">Email</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" id="myInput" name="password" autocomplete="off" class="@error('password') is-invalid @enderror form-control" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" id="password" placeholder="Password" required>
                <label for="password">Password</label>
                <div class="my-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="myFunction()">
                    <label class="form-check-label" for="exampleCheck1">Lihat password</label>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-2 mb-3" type="submit">Daftar</button>
            
        </form>
        <div class="col-lg-12 text-center">
            <p class="text-center d-inline mx-1 ">Sudah pernah mendaftar?</p><a class="text-decoration-none button-registered-or-unregistered " href="/login-admin">Masuk</a>
        </div>
        </main>
        </div>
    </div>
@endsection
@push('js')
<script>
    function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    }
</script>
@endpush