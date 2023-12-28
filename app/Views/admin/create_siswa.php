<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="mb-2">
        <?php if (session()->getFlashdata('pesan_merah')) : ?>
            <div class="swalGagal" data-swalgagal="<?= session()->getFlashdata('pesan_merah'); ?>"></div>
        <?php endif ?>
    </div>

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Data Siswa</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/save_siswa'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="level" value="3">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nis_siswa">Nis</label>
                            <input class="form-control <?= ($validation->hasError('nis_siswa')) ? 'is-invalid' : ''; ?>" name="nis_siswa" id="nis_siswa" type="text" placeholder="nis siswa">
                            <div class="invalid-feedback"><?= $validation->getError('nis_siswa'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nama_siswa">Nama</label>
                            <input class="form-control <?= ($validation->hasError('nama_siswa')) ? 'is-invalid' : ''; ?>" name="nama_siswa" id="nama_siswa" type="text" placeholder="nama" value="<?= old('nama_siswa'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_siswa'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Jenis Kelamin</label>
                        <div class="form-group">
                            <div class="form-control <?= ($validation->hasError('jk')) ? 'is-invalid' : ''; ?>">
                                <div class="icheck-primary d-inline">
                                    <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="L" <?= (old('jk')) == 'L' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="inlineRadio1">(L) Laki-laki</label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="P" <?= (old('jk')) == 'P' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="inlineRadio2">(P) Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('jk'); ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="selectpicker form-control <?= ($validation->hasError('kelas')) ? 'is-invalid' : ''; ?>" name="kelas" data-container="body" data-live-search="true" title="Pilih Kelas">
                                <?php if (old('kelas') == true) : ?>
                                    <optgroup label="pilihan sebelumnya">
                                        <option selected value="<?= old('kelas'); ?>"><?= old('kelas'); ?></option>
                                    </optgroup>
                                <?php endif; ?>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['id_kelas']; ?>"><?= $k['nama_kelas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('kelas'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Pilihan Ekstra</label>
                            <select class="selectpicker form-control <?= ($validation->hasError('pilihan_ekstra')) ? 'is-invalid' : ''; ?>" name="pilihan_ekstra" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                <?php if (old('pilihan_ekstra') == true) : ?>
                                    <optgroup label="pilihan sebelumnya">
                                        <option selected value="<?= old('pilihan_ekstra'); ?>"><?= old('pilihan_ekstra'); ?></option>
                                    </optgroup>
                                <?php endif; ?>
                                <?php foreach ($kegiatan as $k) : ?>
                                    <option value="<?= $k['id_kegiatan']; ?>"><?= $k['nama_kegiatan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('pilihan_ekstra'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="alamat_siswa">Alamat</label>
                            <input type="text" class="form-control <?= ($validation->hasError('jk')) ? 'is-invalid' : ''; ?>" name="alamat_siswa" id="alamat_siswa" value="<?= old('alamat_siswa'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('jk'); ?></div>
                            <small class="text-warning">jika tidak ada ganti "-"</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="password">Password Login</label>
                            <input type="text" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password" value="<?= $get_pass; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Tahun Akademik</label>
                            <select class="selectpicker form-control <?= ($validation->hasError('id_thnAkd')) ? 'is-invalid' : ''; ?>" name="id_thnAkd" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                <?php if (old('id_thnAkd') == true) : ?>
                                    <optgroup label="pilihan sebelumnya">
                                        <option selected value="<?= old('id_thnAkd'); ?>"><?= old('id_thnAkd'); ?></option>
                                    </optgroup>
                                <?php endif; ?>
                                <?php foreach ($thn_akd as $k) : ?>
                                    <option <?= ($k['status'] == 'aktif' ? 'selected' : ''); ?> value="<?= $k['id_thnAkd']; ?>"><?= $k['tahun']; ?> <?= ($k['status'] == 'aktif' ? 'aktif sekarang' : ''); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('id_thnAkd'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Tambah Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_siswa')) ? 'is-invalid' : ''; ?>" name="gambar_siswa" id="gambar_siswa" onchange="previewSiswaImg()">
                            <label class="custom-file-label" for="customFile">Tambah Gambar..</label>
                            <div class="invalid-feedback"><?= $validation->getError('gambar_siswa'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mt-2">
                            <img src="/assets/fotosiswa/default.jpg" class="img-thumbnail imgSiswa-preview" alt="default" style="width: 150px;">
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