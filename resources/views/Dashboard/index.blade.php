@extends('Dashboard.Layouts.main')
@section('container')

@if( auth('administrator')->check() )
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Selamat datang, {{ auth('administrator')->user()->administrator_name }}!</h1>
  </div>
@else
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Selamat datang, {{ auth('teacher')->user()->teacher_name }}!</h1>
  </div>
@endif
    
@endsection
