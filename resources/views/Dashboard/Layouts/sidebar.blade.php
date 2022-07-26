
@if( auth('administrator')->check() )
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-3 text-muted text-uppercase">
      <span>ADMINISTRATOR</span>
      <a class="link-secondary" href="#" aria-label="Add a new report"></a>
    </h6>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
      <!-- <li class="nav-item">
        <a onclick="alert('Halaman dalam perbaikan')" class="nav-link {{ ($active == 'Kelas') ? 'active' : '' }}" href="#">
          <span data-feather="layers" class="align-text-bottom"></span>
          Kelas
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Data Siswa') ? 'active' : '' }}" href="/data-siswa">
          <span data-feather="users" class="align-text-bottom"></span>
          Data Siswa
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Program') ? 'active' : '' }}" href="/program">
          <span data-feather="server" class="align-text-bottom"></span>
          Program
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Guru') ? 'active' : '' }}" href="/teacher">
          <span data-feather="list" class="align-text-bottom"></span>
          Guru
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Aktivasi') ? 'active' : '' }}" href="/aktivasi">
          <span data-feather="fast-forward" class="align-text-bottom"></span>
          Aktivasi
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Sekolah') ? 'active' : '' }}" href="/sekolah">
          <span data-feather="archive" class="align-text-bottom"></span>
          Sekolah
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'PIC') ? 'active' : '' }}" href="/pic">
          <span data-feather="flag" class="align-text-bottom"></span>
          PIC
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Penugasan Guru') ? 'active' : '' }}" href="/assign-teacher">
          <span data-feather="user-check" class="align-text-bottom"></span>
          Assign Guru
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Ruang Kelas') ? 'active' : '' }}" href="/classroom">
          <span data-feather="grid" class="align-text-bottom"></span>
          Ruang Kelas
        </a>
      </li>
    </ul>
    <h6 class="sidebar-heading d-flex justify-content-between px-3 mt-4 align-items-center text-muted text-uppercase">
      <span>PENGATURAN</span>
      <a href="#" class="link-secondary"></a>
    </h6>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="/form-registrasi" class="nav-link {{ ($active == 'Pendaftaran') ? 'active' : '' }}">
        <span data-feather="trello" class="align-text-bottom"></span>
          Pendaftaran
        </a>
      </li>
      <li class="nav-item">
        <form action="/logout-admin" method="post">
          @csrf
          <button class="nav-link px-3 bg-light border-0"><span data-feather="log-out"></span> Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
@else
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-3 text-muted text-uppercase">
      <span>GURU</span>
      <a class="link-secondary" href="#" aria-label="Add a new report"></a>
    </h6>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ ($active == 'Aktivasi') ? 'active' : '' }}" href="/aktivasi">
          <span data-feather="fast-forward" class="align-text-bottom"></span>
          Aktivasi
        </a>
      </li>
      <h6 class="sidebar-heading d-flex justify-content-between px-3 mt-4 align-items-center text-muted text-uppercase">
        <span>PENGATURAN</span>
        <a href="#" class="link-secondary"></a>
      </h6>
      <li class="nav-item">
        <form action="/logout-admin" method="post">
          @csrf
          <button class="nav-link px-3 bg-light border-0"><span data-feather="log-out"></span> Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
@endif
