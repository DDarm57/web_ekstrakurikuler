<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Form Edit Profil</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img src="/assets/fotopembina/<?= $pembina->gambar_pembina; ?>" class="img-thumbnail imgPembina-preview" alt="default" style="width: 150px;"><span class="font-weight-bold"><?= $pembina->nama_pembina; ?></span><span class="text-black-50"><?= $pembina->nip_pembina; ?></span><span> </span></div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profil Setting</h4>
                        </div>
                        <form action="<?= site_url('pembina/update_profile'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row mt-3">
                                <input type="hidden" name="id_pembina" id="" value="<?= $pembina->id_pembina; ?>">
                                <input type="hidden" name="gambarLama" id="" value="<?= $pembina->gambar_pembina; ?>">
                                <div class="col-md-12">
                                    <label class="labels">Nama</label>
                                    <input type="text" name="nama_pembina" class="form-control <?= ($validation->hasError('nama_pembina')) ? 'is-invalid' : ''; ?>" value="<?= $pembina->nama_pembina; ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('nama_pembina'); ?></div>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">NIP</label>
                                    <input type="text" name="nip_pembina" class="form-control <?= ($validation->hasError('np_pembina')) ? 'is-invalid' : ''; ?>" value="<?= $pembina->nip_pembina; ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('nip_pembina'); ?></div>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Alamat</label>
                                    <input type="text" name="alamat" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" value="<?= $pembina->alamat; ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('alamat'); ?></div>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Telepon</label>
                                    <input type="number" name="telp_pembina" class="form-control <?= ($validation->hasError('telp_pembina')) ? 'is-invalid' : ''; ?>" value="<?= $pembina->telp_pembina; ?>">
                                </div>
                                <div class="invalid-feedback"><?= $validation->getError('telp_pembina'); ?></div>
                            </div>
                            <div class="form-group">
                                <label for="">Tambah Gambar</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_pembina')) ? 'is-invalid' : ''; ?>" name="gambar_pembina" id="gambar_pembina" onchange="previewPembinaImg()">
                                    <label class="custom-file-label" for="customFile"><?= $pembina->gambar_pembina; ?></label>
                                    <div class="invalid-feedback"><?= $validation->getError('gambar_pembina'); ?></div>
                                </div>
                            </div>
                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>