<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container">
    <?php if (session()->get('level') == 1) { ?>
        <div class="swal" data-swal="<?= session()->getFlashdata('pesanSwal'); ?>"></div>
    <?php } ?>
    <!-- <?php if (session()->get('log')) : ?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Berhasil Login</h4>
            <h5 class="mb-0"><?= (session()->get('level')) == 1 ? 'Admin' : ''; ?></h5>
            <h5 class="mb-0"><?= (session()->get('level')) == 2 ? 'Pembina' : ''; ?></h5>
            <h5 class="mb-0"><?= (session()->get('level')) == 3 ? 'Siswa' : ''; ?></h5>
        </div>
    <?php endif ?> -->
    <div class="toastHome" data-toastHome="<?= session()->getFlashdata('pesan_toast'); ?>"></div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h4 class="card-title w-100">
                <?= $deskripsi->judul_home; ?>
            </h4>
        </div>
        <div id="collapseOne" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <?= $deskripsi->deskripsi_home; ?>
                <?php if (session()->get('level') == 1) { ?>
                    <div class="mt-2">
                        <a href="<?= site_url('home/edit_home'); ?>" class="btn btn-warning">Edit</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>