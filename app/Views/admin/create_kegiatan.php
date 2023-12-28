<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Data Kegiatan</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/save_kegiatan'); ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama_kegiatan')) ? 'is-invalid' : ''; ?>" name="nama_kegiatan" id="nama_kegiatan" placeholder="nip" value="<?= old('nama_kegiatan'); ?>" onkeyup="this.value = this.value.toUpperCase()">
                    <div class="invalid-feedback"><?= $validation->getError('nama_kegiatan'); ?></div>
                </div>
                <div class="form-group">
                    <label for="">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" id="summernote" cols="30" rows="10"><?= old('deskripsi_kegiatan'); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?= $this->endSection(); ?>