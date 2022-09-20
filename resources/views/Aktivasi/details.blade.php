@extends('Layouts.main')

@section('content')

<div class="container-fluid border border-1 bg-light">


    <div id="navbar-daftar-nilai" class="container-fluid sticky-top navbar mb-5 bg-white d-flex justify-content-center">
        <ul class="nav">
            <li class="nav-item">
                <a class="text-decoration-none border border-0" style="background-color: rgba(255,255,255,0);" href="/">
                    <img src="{{ asset('/img/master-icon.jpg') }}" alt="Logo" width="100" class="d-inline-block align-text-top">
                </a>
            </li>
            <!-- <li class="nav-item p-2" id="nav-hover">
                <a href="#" class="nav-link active">Home</a>
            </li>
            <li class="nav-item p-2" id="nav-hover">
                <a href="#" class="nav-link">Tab 1</a>
            </li>
            <li class="nav-item p-2" id="nav-hover">
                <a href="#" class="nav-link">Tab 2</a>
            </li> -->
        </ul>
    </div>

    <div class="container mb-2">
        <a href="/aktivasi" class="text-decoration-none mb-5"><i class="fa-solid fa-arrow-left mx-2"></i>Kembali</a>
        <h4 id="page-title" class="text-start mb-3 mt-5">Daftar Nilai</h4>
        <div class="card">
            <div class="card-body border border-0" style="border-radius: 5px 5px 0px 0px;">
                <p class="card-title fw-bold">Informasi</p>
                <p class="card-text mb-0"><strong>|></strong> Daftar nilai kelas aktivasi {{ $aktivasi->nama_aktivasi }} 2022. Tata cara pengisian dapat melihat panduan di <a href="#" class="text-decoration-none">sini</a></p>
            </div>
        </div>
    </div>
   
    <div class="container mb-5" id="table-isi">
        <div class="card">
            <div class="card-body content">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            @foreach( $materis as $materi )
                                <th class="materi">{{ $materi['nama_materi'] }}({{ $materi['bobot_materi'] }}%)</th>
                            @endforeach
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $students as $student )
                        <!-- data siswa -->
                        <tr>
                            @if( count($students) > 0)
                            <!-- cek dulu ada siswa nya nggak? -->

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ max($student)['nama_siswa'] }}</td>
                                <!-- max ini karena jumlah nilai diambil dari perhitungan nilai materi id paling besar -->

                                @foreach( $student as $data )
                                <!-- sesuaikan dengan kolom materi -->
                                    <td>{{ $data['nilai'] }}</td>
                                @endforeach
                                <td>{{ max($student)['total_nilai'] / $dibagiProgram }}</td>
                                <!-- ambil total nilainya -->
                                    
                                <td>
                                    <?php $idDaftarNilai = max($student)['daftar_nilai_id']; ?>
                                    <?php $idStudent = max($student)['student_id']; ?>
                                    <?php $idAktivasi = max($student)['aktivasi_id']; ?>
                                    <button onclick="edit('{{ $idDaftarNilai }}', '{{ $idStudent }}', '{{ $idAktivasi }}')" class="edit btn btn-warning btn-sm"><i class="fas fa-pen-to-square"></i></button>
                                </td>
                            @else
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" id="close-form" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="content">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
        <button type="button" class="btn btn-primary" id="submit">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>

   
        
    function edit(idDaftarNilai, studentId, aktivasiId){


        let jumlahMateri = document.getElementsByClassName('materi').length;

        $.ajax({
            type:"GET",
            url:"{{ route('edit') }}",
            data:`jumlahMateri=${jumlahMateri}&idDaftarNilai=${idDaftarNilai}&studentId=${studentId}&aktivasiId=${aktivasiId}`,
            success:function(data){

                console.log(data);
                $("#content").html(data);
                $("#staticBackdrop").modal('show');
            }
        });
        
    }

    $('#submit').on('click', function(){

        let all = document.getElementsByClassName('materi-dari-form');
        let daftar = document.getElementById('daftar-nilai').value;

        $("#close-form").click();
        let data = '';
        for( const cekAll of all ){

            console.log(cekAll);
            let id = cekAll.getAttribute('id');
            console.log(id);
            let val = cekAll.value;
            console.log(val);
            
            let max = all[all.length - 1];
            let idMax = max.getAttribute('id');
            if( id == idMax ){
                
                data = data + id + '=' + val;

            }else{

                data = data + id + '=' + val + '&';
            }

        }

        data = data + '&daftarNilai=' + daftar;
        console.log(data);
        $.ajax({
            type:"GET",
            url:"{{ route('update') }}",
            data:data,
            success:function(data){

                console.log(data);
                $("#table-isi").html(data);
            }
        });
    });

        
    
        
    
</script>
@endpush