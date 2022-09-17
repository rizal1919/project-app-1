<div class="container">
    <?php if(isset($number)): ?>
        <?php $i=1; ?>
        @foreach( $materis as $materi )
            <div class="mb-3">
                <?php $nilai = $materi['nilai']; ?>
                <label for="materi_{{ $materi['id'] }}" class="col-form-label col-form-label-sm">{{ $materi['nama_materi'] }}</label>
                <input type="number" class="materi-dari-form form-control form-control-sm" name="materi_{{ $materi['id'] }}" id="materi_{{ $materi['id'] }}" value="{{ old('', $nilai) }}" placeholder="masukkan nilai" max="100">
            </div>
            <?php $i++; ?>
        @endforeach
        <input type="hidden" id="daftar-nilai" name="id_daftar_nilai" value="{{ $number }}">
    <?php else: ?>
    <?php endif; ?>
</div>