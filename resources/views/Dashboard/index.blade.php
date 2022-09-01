@extends('Dashboard.Layouts.main')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Welcome, {{ auth()->user()->name_admin }}</h1>
</div>
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
          <th><a href="/export-pdf" class="btn btn-primary">Export PDF</a></th>
        </tr>
      @endforeach
    </tbody>
  </table> 
    
@endsection
