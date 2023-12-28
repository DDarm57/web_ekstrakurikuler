<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <div class="mb-2">
        <?php if (session()->getFlashdata('pesan_hijau')) : ?>
            <div class="swal" data-swal="<?= session()->getFlashdata('pesan_hijau'); ?>"></div>
        <?php endif ?>
    </div>

    <div class="mb-2">
        <?php if (session()->getFlashdata('pesan_merah')) : ?>
            <div class="swalGagal" data-swalgagal="<?= session()->getFlashdata('pesan_merah'); ?>"></div>
        <?php endif ?>
    </div>

    <div class="h2">
        <div class="text-right">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cekTemplate">
                <i class="fas fa-file-excel"></i> Unduh Template
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cekTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contoh Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <img src="/assets/contoh_import.png" alt="contoh_import.jpg" class="img-thumbnail">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= site_url('admin/template_import'); ?>" class="btn btn-primary">Simpan</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Import Excel</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/save_excel'); ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Validasi Siswa</label>
                            <select class="selectpicker form-control <?= ($validation->hasError('status_validasi')) ? 'is-invalid' : ''; ?>" name="status_validasi" data-container="body" data-live-search="true" title="Pilih Status">
                                <option value="sudah validasi">Otomatis Validasi Nilai</option>
                                <option value="validasi nilai">Manual Validasi Nilai</option>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('status_validasi'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="fileimport">
                    <label for="import_excel">Masukan File Excel</label>
                    <input type="file" name="fileimport" class="form-control-file <?= ($validation->hasError('fileimport')) ? 'is-invalid' : ''; ?>" value="<?= old('fileimport'); ?>">
                    <div class="invalid-feedback"><?= $validation->getError('fileimport'); ?></div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?= $this->endSection(); ?>