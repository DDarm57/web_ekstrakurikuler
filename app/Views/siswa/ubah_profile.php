<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Form Edit Data Siswa</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('siswa/update_profile'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_siswa" value="<?= $siswa->id_siswa; ?>">
                <input type="hidden" name="gambarLama" value="<?= $siswa->gambar_siswa; ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nis_siswa">Nis</label>
                            <input class="form-control <?= ($validation->hasError('nis_siswa')) ? 'is-invalid' : ''; ?>" name="nis_siswa" id="nis_siswa" type="text" placeholder="nis siswa" value="<?= $siswa->nis_siswa; ?>" aria-readonly="true" readonly>
                            <div class="invalid-feedback"><?= $validation->getError('nis_siswa'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nama_siswa">Nama</label>
                            <input class="form-control" name="nama_siswa" id="nama_siswa" type="text" placeholder="nama" value="<?= $siswa->nama_siswa; ?>" readonly>

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Jenis Kelamin</label>
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="L" <?= ($siswa->jk) == 'L'  ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="P" <?= ($siswa->jk) == 'P'  ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_siswa">Alamat</label>
                    <input type="text" class="form-control" name="alamat_siswa" id="alamat_siswa" value="<?= $siswa->alamat_siswa; ?>">
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Tambah Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_siswa')) ? 'is-invalid' : ''; ?>" name="gambar_siswa" id="gambar_siswa" onchange="previewSiswaImg()">
                            <label class="custom-file-label" for="customFile"><?= $siswa->gambar_siswa; ?></label>
                            <div class="invalid-feedback"><?= $validation->getError('gambar_siswa'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mt-2">
                            <img src="/assets/fotosiswa/<?= $siswa->gambar_siswa; ?>" class="img-thumbnail imgSiswa-preview" alt="default" style="width: 150px;">
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