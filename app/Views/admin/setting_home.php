<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container">
    <div class="mb-2">
        <?php if (session()->getFlashdata('pesan_hijau')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan_hijau'); ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('pesan_merah')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('pesan_merah'); ?>
            </div>
        <?php endif ?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card card-primary card-outline">
                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            Selamat Datang di Web Ekstrakurikuler SMAN 1 PADEMAWU
                        </h4>
                    </div>
                </a>
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <?= $deskripsi->deskripsi_home; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-primary card-outline">
                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            Edit Halaman Home
                        </h4>
                    </div>
                </a>
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="text-right mb-2">
                            <button class="btn btn-warning" onclick="myFunction()">Edit</button>
                        </div>
                        <form action="<?= site_url('admin/update_home'); ?>" method="POST">
                            <input type="hidden" name="id_setHome" value="<?= $deskripsi->id_setHome; ?>">
                            <textarea name="deskripsi_home" id="summernote" readonly><?= $deskripsi->deskripsi_home; ?></textarea>
                            <small class="text-danger"><?= $validation->getError('deskripsi_home'); ?></small>
                            <button type="submit" id="buka" disabled class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        document.getElementById("buka").disabled = false;
    }
</script>

<?= $this->endSection(); ?>