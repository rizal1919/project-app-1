@extends('Dashboard.Layouts.main')

@section('container')
<div class="container-lg mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
        <div class="card p-3">
            <div class="card-header mb-1 rounded">
                <h4 class="card-title">Data Siswa - Kurikulum {{ $kurikulum->nama_kurikulum }}</h4>
            </div>
            <div class="card-body">
                @if( session('destroy') )
                <div class="alert alert-success alert-dismissible fade show" id="hide" role="alert">
                    <strong>{{ session('destroy') }}</strong> Data siswa telah berhasil dihapus.
                    <button type="button" class="btn-close" onclick="changeStyle()" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="row d-flex justify-content-end">
                    <div class="col-md-12 d-flex mt-4 justify-content-end">
                        <form action="/kelas-admin/show/{{ $kurikulum->id }}" method="get" class="mx-2" style="width: 90%;" >
                            @csrf
                            <div class="input-group">
                                <input type="text" name="nama_siswa" value="{{ request()->nama_siswa }}" class="form-control text-end" placeholder="Nama">
                                <input type="text" name="ktp" value="{{  request()->ktp }}" class="form-control text-end" placeholder="No KTP">
                                <input type="text" name="tahun_daftar" value="{{ request()->tahun_daftar }}" class="form-control text-end" placeholder="Tahun">
                                <button class="btn btn-primary" id="basic-addon2">Cari!</button>
                            </div>
                        </form>
                        <a href="/kelas-admin" class="text-decoration-none text-light btn btn-primary self-align-center" style="width: 10%; height: 100%;">Kembali</a>
                    </div>
                </div>
                
            </div>
            <div class="card-body">
                <div class="card p-3">
                    <table class="table table-light table-hover table-striped" style="border-radius: 5px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>KTP</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tahun Diterima</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $dataSiswa as $dasis )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dasis['nama_siswa'] }}</td>
                                <td>{{ $dasis['email'] }}</td>
                                <td>{{ $dasis['ktp'] }}</td>
                                <td class="text-center"><span class="badge text-bg-primary">{{ $dasis['status'] }}</span></td>
                                <td class="text-center">{{ $dasis['tahun_daftar'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $dataSiswa->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function changeStyle(){
        var element = document.getElementById("hide");
        element.style.display = "none";
    }
</script>
<script>
    function confirmation(delId){
    var del=confirm(`Anda yakin ingin menghapus siswa dengan nama ${delId} ?`);
    if (del==true){
        window.location.href=`/kelas-admin/delete/student/${delId}`;
    }
    return del;
    }
</script>
@endpush