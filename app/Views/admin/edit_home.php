<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container">
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
                <form action="<?= site_url('home/update_home'); ?>" method="POST">
                    <input type="hidden" name="id_setHome" id="" value="<?= $home->id_setHome; ?>">
                    <div class="form-group">
                        <label for="judul_home">Judul Header Home</label>
                        <input type="text" name="judul_home" id="" class="form-control" value="<?= $home->judul_home; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi_home" id="summernote" readonly><?= $home->deskripsi_home; ?></textarea>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>