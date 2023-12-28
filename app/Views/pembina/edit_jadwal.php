<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Form Edit Data Jadwal</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pembina/update_jadwal'); ?>" method="POST">
                <input type="hidden" name="J_kegiatan" value="<?= session()->get('kegiatan'); ?>">
                <input type="hidden" name="id_jadwal" id="" value="<?= $jadwal->id_jadwal; ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="J_hari">Hari</label>
                            <select name="J_hari" id="" class="form-control <?= ($validation->hasError('J_hari')) ? 'is-invalid' : ''; ?>">
                                <option <?= ($jadwal->J_hari) == 'Senin' ? 'selected' : ''; ?> value="Senin">Senin</option>
                                <option <?= ($jadwal->J_hari) == 'Selasa' ? 'selected' : ''; ?> value="Selasa">Selasa</option>
                                <option <?= ($jadwal->J_hari) == 'Rabu' ? 'selected' : ''; ?> value="Rabu">Rabu</option>
                                <option <?= ($jadwal->J_hari) == 'Kamis' ? 'selected' : ''; ?> value="Kamis">Kamis</option>
                                <option <?= ($jadwal->J_hari) == "Jum'at" ? 'selected' : ''; ?> value="Jum'at">Jum'at</option>
                                <option <?= ($jadwal->J_hari) == 'Sabtu' ? 'selected' : ''; ?> value="Sabtu">Sabtu</option>
                                <option <?= ($jadwal->J_hari) == 'Minggu' ? 'selected' : ''; ?> value="Minggu">Minggu</option>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('J_hari'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="J_waktu">Waktu</label>
                            <input type="time" name="J_waktu" id="J_waktu" class="form-control <?= ($validation->hasError('J_waktu')) ? 'is-invalid' : ''; ?>" value="<?= $jadwal->J_waktu; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('J_waktu'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="J_materi">Materi</label>
                            <input type="text" name="J_materi" id="J_materi" class="form-control <?= ($validation->hasError('J_materi')) ? 'is-invalid' : ''; ?>" value="<?= $jadwal->J_materi; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('J_materi'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="J_keterangan">Keterangan</label>
                            <textarea name="J_keterangan" id="summernote" cols="30" rows="10"><?= $jadwal->J_keterangan; ?></textarea>
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