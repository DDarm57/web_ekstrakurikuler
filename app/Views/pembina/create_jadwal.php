<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Data Jadwal</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pembina/save_jadwal'); ?>" method="POST">
                <input type="hidden" name="J_kegiatan" value="<?= session()->get('kegiatan'); ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="J_tanggal">Pilih tanggal</label>
                            <select class="selectpicker form-control" name="J_tanggal" data-container="body" data-live-search="true" title="pilih tanggal">
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    $num_padded = sprintf("%02d", $i);
                                    echo '<option value="' . $num_padded . '">' . $num_padded . '</option>;';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="J_bulan">Pilih Bulan</label>
                            <input type="month" name="J_bulan" class="form-control <?= ($validation->hasError('J_bulan')) ? 'is-invalid' : ''; ?>" id="">
                            <div class="invalid-feedback"><?= $validation->getError('J_bulan'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="J_waktu">Waktu</label>
                            <input type="time" name="J_waktu" id="J_waktu" class="form-control <?= ($validation->hasError('J_waktu')) ? 'is-invalid' : ''; ?>" value="<?= old('J_waktu'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('J_waktu'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="J_materi">Materi</label>
                            <input type="text" name="J_materi" id="J_materi" class="form-control <?= ($validation->hasError('J_materi')) ? 'is-invalid' : ''; ?>" value="<?= old('J_materi'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('J_materi'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="J_keterangan">Keterangan</label>
                            <textarea name="J_keterangan" id="summernote" cols="30" rows="10"><?= old('J_keterangan'); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<?= $this->endSection(); ?>