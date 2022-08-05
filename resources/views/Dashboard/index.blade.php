@extends('Layouts.main')
@section('content')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SC Academy</title>
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand text-center col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">SC Academy</a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
      <div class="navbar-nav">
        <div class="nav-item text-nowrap">
          <form action="/logout-admin" method="post">
            @csrf
            <button class="nav-link px-3 bg-dark border-0">Logout</button>
          </form>
        </div>
      </div>
    </header>
    <div class="container-fluid">
      <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
          <div class="position-sticky pt-3 sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                  <span data-feather="home" class="align-text-bottom"></span>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/form-registrasi-1">
                  <span data-feather="file" class="align-text-bottom"></span>
                  Pendaftaran
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/kelas-admin">
                  <span data-feather="shopping-cart" class="align-text-bottom"></span>
                  Kelas
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/data-siswa">
                  <span data-feather="users" class="align-text-bottom"></span>
                  Data Siswa
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/kurikulum">
                  <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                  Program
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Welcome, {{ auth()->user()->name_admin }}</h1>
          </div>
          @if( session('pendaftaranBerhasil') )
          <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
              <strong>{{ session('pendaftaranBerhasil') }}</strong> adalah kode untuk aktivasi program.
              <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
            <table class="table table-hover mt-5 table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Admin</th>
                  <th>Email</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $admins as $admin )
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <th>{{ $admin->name_admin }}</th>
                    <th>{{ $admin->email }}</th>
                    <th><p class="badge text-bg-primary" style="letter-spacing: 1px;">active</p></th>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </main>
      </div>
    </div>


      <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
      <script src="js/dashboard.js"></script>
  </body>
</html>

@endsection
@push('js')

@endpush