@extends('Layouts.main')
@section('content')
    @include('Dashboard.Layouts.header')
    <div class="container-fluid">
      <div class="row">
        @include('Dashboard.Layouts.sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          @yield('container')
        </main>
      </div>
    </div>
@endsection
@push('js')

@endpush