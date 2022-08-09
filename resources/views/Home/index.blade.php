@extends('Layouts.main')


<div class="container-fluid">
    <div class="col-lg-12 p-4 d-flex justify-content-end">
        <ul class="nav nav-pills">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Login</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item {{ ($active == 'Login') ? 'active' : '' }}" href="#">Siswa</a></li>
                <li><a class="dropdown-item {{ ($active == 'Login') ? 'active' : '' }}" href="/login-admin">Admin</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item {{ ($active == 'Login') ? 'active' : '' }}" href="#">Daftar Siswa Baru</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ($active == 'Home') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
            </li>
        </ul>
    </div>
</div>
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" style="width: 100%; height: 70%;" data-bs-interval="10000">
      <img src="https://source.unsplash.com/1000x1000?man" class="d-block w-100" alt="images">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="text-light">First slide label</h5>
        <p class="text-light">Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="5000" style="width: 100%; height: 70%;">
      <img src="https://source.unsplash.com/1000x1000?asian" class="d-block w-100" alt="images">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="text-light">Second slide label</h5>
        <p class="text-light">Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="1000" style="width: 100%; height: 70%;">
      <img src="https://source.unsplash.com/1000x1000?college" class="d-block w-100" alt="images">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="text-light">Third slide label</h5>
        <p class="text-light">Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<footer class="container mt-5">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
