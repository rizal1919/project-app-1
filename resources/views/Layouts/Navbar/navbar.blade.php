<nav class="navbar navbar-expand-lg bg-light p-4 ml-5">
  <div class="container-lg">
    <a class="navbar-brand" href="/dashboard">
        <i class="fa-solid fa-building-columns"></i>
      <!-- <img src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24"> -->
    </a>
    <a class="navbar-brand {{ ($active === 'Dashboard Admin') ? 'active' : '' }}" href="/dashboard">DASHBOARD</a>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link {{ ($active === 'Pendaftaran') ? 'active fw-bold' : '' }}" href="/pendaftaran">Pendaftaran</a>
        <a class="nav-link {{ ($active === 'Kelas') ? 'active fw-bold' : '' }}" href="/kelas-admin">Kelas</a>
        <a class="nav-link {{ ($active === 'Data Siswa') ? 'active fw-bold' : '' }}" href="#">Data Siswa</a>
        <a class="nav-link {{ ($active === 'Daftar Kurikulum') ? 'active fw-bold' : '' }}" href="/program">Daftar Kurikulum</a>
      </div>
      <div class="navbar-nav">
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selamat datang, {{ auth()->user()->name_admin }}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/dashboard"><i class="fa-solid fa-book mx-1"></i>Dashboard</a></li>
            <li><hr class="dropdown-divider"></li>
            <form action="/logout-admin" method="post">
              @csrf
              <!-- <li><a class="dropdown-item" href="/logout-admin"><i class="fa-solid fa-square-caret-left mx-1"></i>Logout</a></li> -->
              <li><button class="dropdown-item" type="submit"><i class="fa-solid fa-square-caret-left mx-1"></i>Logout</button></li>  
            </form>
          </ul>
        </li>
        @else
        <a href="/login-admin" class="nav-link {{ ($active === 'Login') ? 'active' : '' }}"><i class="fa-solid fa-right-from-bracket mx-2"></i>Login</a>
        
        @endauth
      </div>
    </div>
  </div>
</nav>