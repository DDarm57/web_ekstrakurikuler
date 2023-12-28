<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <?php if (session()->getFlashdata('pesan_merah')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('pesan_merah'); ?>
        </div>
    <?php endif ?>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Simpan Excel</h3>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pembina/excel'); ?>" method="POST">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" class="form-control" value="<?= $thn_akd; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <select class="selectpicker form-control" name="tanggal" data-container="body" data-live-search="true" title="pilih tanggal">
                                <?php for ($i = 1; $i <= 31; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>;';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Bulan</label>
                            <select class="selectpicker form-control" name="bulan" data-container="body" data-live-search="true" title="Pilih Bulan">
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Tahun</label>
                            <input type="text" name="tahun" class="form-control" value="<?= date('Y'); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Kegiatan</label>
                    <input type="text" name="kegiatan" class="form-control" value="<?= session()->get('kegiatan'); ?>" readonly>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?= $this->endSection(); ?>