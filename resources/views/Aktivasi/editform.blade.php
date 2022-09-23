<div class="container">
    <?php if(isset($idDaftarNilai)): ?>
        <?php $i=1; ?>
        @foreach( $materis as $materi )
            <?php $nilai = $materi['nilai']; ?>
            <?php $id = $materi['id']; ?>

            @if( auth('teacher')->check() )

                @if( in_array( $id, $materiDitugaskan ) )
                <!-- cek apakah materi memang ditugaskan untuk guru yang sedang login -->
                    <div class="mb-3">
                        <label for="materi_{{ $materi['id'] }}" class="col-form-label col-form-label-sm">{{ $materi['nama_materi'] }}</label>
                        <input type="number" class="materi-dari-form form-control form-control-sm" name="materi_{{ $materi['id'] }}" id="materi_{{ $materi['id'] }}" value="{{ old('', $nilai) }}" placeholder="masukkan nilai" max="100">
                    </div>
                @else
                <!-- jika bukan, maka kunci inputnya -->
                    <div class="mb-3">
                        <label for="materi_{{ $materi['id'] }}" class="col-form-label col-form-label-sm">{{ $materi['nama_materi'] }}<i class="fa-solid fa-lock mx-2"></i></label>
                        <input type="number" class="materi-dari-form form-control form-control-sm" name="materi_{{ $materi['id'] }}" id="materi_{{ $materi['id'] }}" value="{{ old('', $nilai) }}" placeholder="masukkan nilai" max="100" readonly>
                    </div>
                @endif

            @else

                <div class="mb-3">
                    <label for="materi_{{ $materi['id'] }}" class="col-form-label col-form-label-sm">{{ $materi['nama_materi'] }}</label>
                    <input type="number" class="materi-dari-form form-control form-control-sm" name="materi_{{ $materi['id'] }}" id="materi_{{ $materi['id'] }}" value="{{ old('', $nilai) }}" placeholder="masukkan nilai" max="100">
                </div>
                
            @endif


            <?php $i++; ?>
        @endforeach
        <input type="hidden" id="daftar-nilai" name="id_daftar_nilai" value="{{ $idDaftarNilai }}">
    <?php endif; ?>
</div>