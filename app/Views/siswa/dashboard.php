<?= $this->extend('layout/template'); ?>

<?= $this->Section('page-content'); ?>
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

    <div class="row gutters-sm">
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/fotosiswa/<?= $siswa->gambar_siswa; ?>" alt="Admin" class="img-thumbnail" width="150">
                        <div class="mt-3">
                            <h4><?= $siswa->nis_siswa; ?></h4>
                            <p class="text-secondary mb-1"><?= $siswa->nama_siswa; ?></p>
                            <p class="text-muted font-size-sm"><?= $siswa->nama_kegiatan; ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NIS</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $siswa->nis_siswa; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama Lengkap</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $siswa->nama_siswa; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Ekstrakurikuler</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $siswa->nama_kegiatan; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Alamat</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $siswa->alamat_siswa; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-info " href="<?= site_url('siswa/ubah_profile'); ?>/<?= $siswa->id_siswa; ?>">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
<?= $this->endSection(); ?>