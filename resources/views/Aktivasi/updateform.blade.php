<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $alert }}</strong> nilai berhasil diubah.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
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