@extends('Layouts.main')
@section('content')
    @include('Dashboard.Layouts.header')
    <div class="container-fluid">
      <div class="row">
        @include('Dashboard.Layouts.sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <!-- <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar" class="align-text-bottom"></span>
              This week
            </button>
          </div> -->
          
          @yield('container')
        </main>
      </div>
    </div>
@endsection
@push('js')

@endpush