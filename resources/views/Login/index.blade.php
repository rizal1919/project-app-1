@extends('layouts.main')

@section('content')

    <div class="container mt-5">
        <div class="col-lg-6 text-center mx-auto" >
        @if( session('success') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('success') }}</strong> Silahkan login untuk informasi lainnya.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if( session('logoutSuccess') )
        <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('logoutSuccess') }}</strong> Terima kasih untuk hari ini.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if( session('loginError') )
        <div class="alert alert-danger alert-dismissible fade show" id="hide" role="alert">
            <strong>{{ session('loginError') }}</strong> Maaf autentikasi username/password anda salah.
            <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        </div>
    </div>
        
    <div class="row justify-content-center align-items-center" style='height: 500px; margin-bottom: -1px;'>
        <div class="col-lg-3">
        <main class="form-signin w-100 m-auto">
        <form action="/login-admin" method="post">
            @csrf
            <h1 class="h3 mb-4 fw-normal text-center"></i>Silahkan login</h1>
            <div class="form-floating">
                <input type="text" name="username_admin" value="{{ old('username_admin') }}"  class="form-control @error('username_admin') is-invalid @enderror" id="username_admin" placeholder="username_admin" style="border-radius: 5px 5px 0px 0px; margin-bottom: -1px;" required autofocus>
                <label for="username_admin">Username</label>
                @error('username_admin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="myInput" style="border-radius: 0px 0px 5px 5px; margin-bottom: -1px;" placeholder="Password" required>
                <label for="password">Password</label>
                <div class="my-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="myFunction()">
                    <label class="form-check-label" for="exampleCheck1">Lihat password</label>
                </div>
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-3 mb-3" type="submit">Masuk</button>
            
        </form>
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

<script>
    function changeStyle(){
        var element = document.getElementById("hide");
        element.style.display = "none";
    }
    
</script>

@endpush