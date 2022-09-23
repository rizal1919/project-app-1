<div class="container">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $alert }}</strong> nilai berhasil diubah.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php $counter = 0; ?>
@foreach( $datas as $data )
    <div class="container">
        <div class="card-body text-bg-primary col-sm-3 border-bottom-0 p-3" id="headTitle">
            <p class="card-title">{{ $programs[$counter]->nama_program }}</p>
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