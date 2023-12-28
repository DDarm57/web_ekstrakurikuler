<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Form Edit Data Siswa</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/update_siswa'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="level" value="3">
                <input type="hidden" name="siswa_userid" value="<?= $siswa->siswa_userid; ?>">
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
                            <input class="form-control" name="nama_siswa" id="nama_siswa" type="text" placeholder="nama" value="<?= $siswa->nama_siswa; ?>">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Jenis Kelamin</label>
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="Laki-laki" <?= ($siswa->jk) == 'L' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="Perempuan" <?= ($siswa->jk) == 'P' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select name="kelas" class="form-control select2" id="kelas" style="width: 100%;">
                                <optgroup label="MIPA">
                                    <option <?= ($siswa->kelas) == 'X MIPA 1' ? 'selected' : ''; ?> value="X MIPA 1">X MIPA 1</option>
                                    <option <?= ($siswa->kelas) == 'X MIPA 2' ? 'selected' : ''; ?> value="X MIPA 2">X MIPA 2</option>
                                    <option <?= ($siswa->kelas) == 'X MIPA 3' ? 'selected' : ''; ?> value="X MIPA 3">X MIPA 3</option>
                                    <option <?= ($siswa->kelas) == 'X MIPA 4' ? 'selected' : ''; ?> value="X MIPA 4">X MIPA 4</option>
                                    <option <?= ($siswa->kelas) == 'XI MIPA 1' ? 'selected' : ''; ?> value="XI MIPA 1">XI MIPA 1</option>
                                    <option <?= ($siswa->kelas) == 'XI MIPA 2' ? 'selected' : ''; ?> value="XI MIPA 2">XI MIPA 2</option>
                                    <option <?= ($siswa->kelas) == 'XI MIPA 3' ? 'selected' : ''; ?> value="XI MIPA 3">XI MIPA 3</option>
                                    <option <?= ($siswa->kelas) == 'XI MIPA 4' ? 'selected' : ''; ?> value="XI MIPA 4">XI MIPA 4</option>
                                    <option <?= ($siswa->kelas) == 'XII MIPA 1' ? 'selected' : ''; ?> value="XII MIPA 1">XII MIPA 1</option>
                                    <option <?= ($siswa->kelas) == 'XII MIPA 2' ? 'selected' : ''; ?> value="XII MIPA 2">XII MIPA 2</option>
                                    <option <?= ($siswa->kelas) == 'XII MIPA 3' ? 'selected' : ''; ?> value="XII MIPA 3">XII MIPA 3</option>
                                    <option <?= ($siswa->kelas) == 'XII MIPA 4' ? 'selected' : ''; ?> value="XII MIPA 4">XII MIPA 4</option>
                                </optgroup>
                                <optgroup label="IPA">
                                    <option <?= ($siswa->kelas) == 'X IPA 1' ? 'selected' : ''; ?> value="X IPA 1">X IPA 1</option>
                                    <option <?= ($siswa->kelas) == 'X IPA 2' ? 'selected' : ''; ?> value="X IPA 2">X IPA 2</option>
                                    <option <?= ($siswa->kelas) == 'X IPA 3' ? 'selected' : ''; ?> value="X IPA 3">X IPA 3</option>
                                    <option <?= ($siswa->kelas) == 'X IPA 4' ? 'selected' : ''; ?> value="X IPA 4">X IPA 4</option>
                                    <option <?= ($siswa->kelas) == 'XI IPA 1' ? 'selected' : ''; ?> value="XI IPA 1">XI IPA 1</option>
                                    <option <?= ($siswa->kelas) == 'XI IPA 2' ? 'selected' : ''; ?> value="XI IPA 2">XI IPA 2</option>
                                    <option <?= ($siswa->kelas) == 'XI IPA 3' ? 'selected' : ''; ?> value="XI IPA 3">XI IPA 3</option>
                                    <option <?= ($siswa->kelas) == 'XI IPA 4' ? 'selected' : ''; ?> value="XI IPA 4">XI IPA 4</option>
                                    <option <?= ($siswa->kelas) == 'XII IPA 1' ? 'selected' : ''; ?> value="XII IPA 1">XII IPA 1</option>
                                    <option <?= ($siswa->kelas) == 'XII IPA 2' ? 'selected' : ''; ?> value="XII IPA 2">XII IPA 2</option>
                                    <option <?= ($siswa->kelas) == 'XII IPA 3' ? 'selected' : ''; ?> value="XII IPA 3">XII IPA 3</option>
                                    <option <?= ($siswa->kelas) == 'XII IPA 4' ? 'selected' : ''; ?> value="XII IPA 4">XII IPA 4</option>
                                </optgroup>
                                <optgroup label="IPS">
                                    <option <?= ($siswa->kelas) == 'X IPS 1' ? 'selected' : ''; ?> value="X IPS 1">X IPS 1</option>
                                    <option <?= ($siswa->kelas) == 'X IPS 2' ? 'selected' : ''; ?> value="X IPS 2">X IPS 2</option>
                                    <option <?= ($siswa->kelas) == 'X IPS 3' ? 'selected' : ''; ?> value="X IPS 3">X IPS 3</option>
                                    <option <?= ($siswa->kelas) == 'X IPS 4' ? 'selected' : ''; ?> value="X IPS 4">X IPS 4</option>
                                    <option <?= ($siswa->kelas) == 'XI IPS 1' ? 'selected' : ''; ?> value="XI IPS 1">XI IPS 1</option>
                                    <option <?= ($siswa->kelas) == 'XI IPS 2' ? 'selected' : ''; ?> value="XI IPS 2">XI IPS 2</option>
                                    <option <?= ($siswa->kelas) == 'XI IPS 3' ? 'selected' : ''; ?> value="XI IPS 3">XI IPS 3</option>
                                    <option <?= ($siswa->kelas) == 'XI IPS 4' ? 'selected' : ''; ?> value="XI IPS 4">XI IPS 4</option>
                                    <option <?= ($siswa->kelas) == 'XII IPS 1' ? 'selected' : ''; ?> value="XII IPS 1">XII IPS 1</option>
                                    <option <?= ($siswa->kelas) == 'XII IPS 2' ? 'selected' : ''; ?> value="XII IPS 2">XII IPS 2</option>
                                    <option <?= ($siswa->kelas) == 'XII IPS 3' ? 'selected' : ''; ?> value="XII IPS 3">XII IPS 3</option>
                                    <option <?= ($siswa->kelas) == 'XII IPS 4' ? 'selected' : ''; ?> value="XII IPS 4">XII IPS 4</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="california">Pilihan Ekstra</label>
                            <input type="text" class="form-control" name="pilihan_ekstra" id="pilihan_ekstra" value="<?= $siswa->pilihan_ekstra; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="alamat_siswa">Alamat</label>
                            <input type="text" class="form-control" name="alamat_siswa" id="alamat_siswa" value="<?= $siswa->alamat_siswa; ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password Login</label>
                            <input type="text" class="form-control" name="password" id="password" value="<?= $siswa->password; ?>">
                        </div>
                    </div>
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