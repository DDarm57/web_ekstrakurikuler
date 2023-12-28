<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Edit Data Pembina</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/update_pembina'); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="pembina_userid" id="pembina_userid" value="<?= $pembina->pembina_userid; ?>">
                <input type="hidden" name="level" id="level" value="2">
                <input type="hidden" name="gambarLama" value="<?= $pembina->gambar_pembina; ?>">
                <input type="hidden" name="id" id="id" value="<?= $pembina->id; ?>">
                <input type="hidden" name="created_at" value="<?= $pembina->created_at; ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nip_pembina">Nip</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nip_pembina')) ? 'is-invalid' : ''; ?>" name="nip_pembina" id="nip_pembina" placeholder="nip" value="<?= $pembina->nip_pembina; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('nip_pembina'); ?></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama_pembina">Nama</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama_pembina')) ? 'is-invalid' : ''; ?>" name="nama_pembina" id="nama_pembina" placeholder="nama" value="<?= $pembina->nama_pembina; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('nama_pembina'); ?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" name="alamat" id="alamat" placeholder="alamat" value="<?= $pembina->alamat; ?>">
                    <div class="invalid-feedback"><?= $validation->getError('alamat'); ?></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">Mengajar</label>
                        <select class="form-control select2 <?= ($validation->hasError('mengajar')) ? 'is-invalid' : ''; ?>" id="mengajar" name="mengajar" style="width: 100%;">
                            <?php if (old('mengajar')) : ?>
                                <optgroup label="pilihan Sebelumnya">
                                    <option value="<?= old('mengajar'); ?>"><?= ($pembina->mengajar_kegiatan == old('mengajar') ? $pembina->nama_kegiatan : ''); ?></option>
                                </optgroup>
                            <?php endif; ?>
                            <?php foreach ($kegiatan as $k) : ?>
                                <option <?= ($pembina->mengajar_kegiatan == $k['id_kegiatan'] ? 'selected' : ''); ?> value="<?= $k['id_kegiatan']; ?>"><?= $k['nama_kegiatan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('mengajar'); ?></div>
                    </div>
                    <div class="form-group col">
                        <label for="telp_pembina">No Telp</label>
                        <input type="text" class="form-control <?= ($validation->hasError('telp_pembina')) ? 'is-invalid' : ''; ?>" name="telp_pembina" id="telp_pembina" value="<?= $pembina->telp_pembina; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('telp_pembina'); ?></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="username">Username Login</label>
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="username" value="<?= $pembina->username; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                    </div>

                    <div class="form-group col">
                        <label for="password">Password Login</label>
                        <input type="text" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password" value="<?= $pembina->password; ?>">
                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="">Tambah Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_pembina')) ? 'is-invalid' : ''; ?>" name="gambar_pembina" id="gambar_pembina" onchange="previewPembinaImg()">
                            <label class="custom-file-label" for="customFile"><?= $pembina->gambar_pembina; ?></label>
                            <div class="invalid-feedback"><?= $validation->getError('gambar_pembina'); ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mt-2">
                            <img src="/assets/fotopembina/<?= $pembina->gambar_pembina; ?>" class="img-thumbnail imgPembina-preview" alt="default" style="width: 150px;">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">UBAH</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?= $this->endSection(); ?>