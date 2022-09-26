@extends('Layouts.main')

@section('content')

<div class="container-fluid border border-1 bg-light" id="top-nav">

    <div id="navbar-daftar-nilai" class="container-fluid sticky-top navbar mb-5 bg-white d-flex justify-content-center" style="width: 100%;">
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

    <div class="container mb-4">
        <a href="/aktivasi" class="text-decoration-none mb-5"><i class="fa-solid fa-arrow-left mx-2"></i>Kembali</a>
        <h4 id="page-title" class="text-start mb-3 mt-5">Daftar Nilai</h4>
        <div class="card">
            <div class="card-body border border-0" style="border-radius: 5px 5px 0px 0px;">
                <p class="card-title fw-bold">Informasi</p>
                <p class="card-text mb-0"><strong>|></strong> Daftar nilai kelas aktivasi {{ $aktivasi->nama_aktivasi }} 2022. Tata cara pengisian dapat melihat panduan di <a href="#" class="text-decoration-none">sini</a></p>
            </div>
        </div>
    </div>
    
    <div id="table-isi">
        <?php $counter = 0; ?>
        @foreach( $datas as $data )
            <div class="container">
                <div class="card-body text-bg-primary col-sm-3 border-bottom-0 p-3" id="headTitle">
                    <p class="card-title">{{ $programs[$counter] }}</p>
                </div>
            </div>
            <?php $counter++; ?>
            <div class="container mb-4" id="table-isi">
                <div class="card" style="border-radius: 0px 5px 5px 5px;">
                    <div class="card-body content">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    @if( count($data) !== 0 )
                                        @foreach( max($data) as $materi )
                                            <th>{{ $materi['nama_materi'] }}</th>
                                        @endforeach
                                    @endif
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $data as $student )
                                    <tr>
                                        
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ max($student)['nama_siswa'] }}</td>
                                        @foreach( $student as $skor )
                                            <td>{{ $skor['nilai'] }}</td>
                                            <?php $idPenilaian = $skor['idPenilaian']; ?>
                                            <?php $studentId = $skor['idSiswa']; ?>
                                            <?php $aktivasiId = $skor['idAktivasi']; ?>
                                            <?php $programId = $skor['idProgram']; ?>
                                        @endforeach
                                        <?php $availables = max($student)['availables']; ?>
                                        <td>{{ max($student)['total_nilai'] }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-url="/delete-aktivasi-program/" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="edit('{{ $idPenilaian }}', '{{ $studentId }}', '{{ $aktivasiId }}', '{{ $programId }}', '{{ $availables }}')"><i class="fa fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-chalkboard-user mx-2"></i>Form Penilaian</h5>
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

   
        
    function edit(idDaftarNilai, studentId, aktivasiId, programId, availables){

        let data = `programId=${programId}&idDaftarNilai=${idDaftarNilai}&studentId=${studentId}&aktivasiId=${aktivasiId}&availables=${availables}`;
        console.log(data);
        
        $.ajax({
            type:"GET",
            url:"{{ route('edit') }}",
            data:`programId=${programId}&idDaftarNilai=${idDaftarNilai}&studentId=${studentId}&aktivasiId=${aktivasiId}&availables=${availables}`,
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