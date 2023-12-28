<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <div class="mb-2">
        <?php if (session()->getFlashdata('pesan_hijau')) : ?>
            <div class="swal" data-swal="<?= session()->getFlashdata('pesan_hijau'); ?>"></div>
        <?php endif ?>
        <?php if (session()->getFlashdata('pesan_merah')) : ?>
            <div class="swalGagal" data-swalgagal="<?= session()->getFlashdata('pesan_merah'); ?>"></div>
        <?php endif ?>
    </div>

    <div class="mb-2">
        <a href="<?= site_url('admin/create_kegiatan'); ?>" class="btn btn-primary">Tambah Data</a>
    </div>

    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Kegiatan
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Deskripsi Kegiatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($kegiatan as $k) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $k['nama_kegiatan']; ?></td>
                            <td><?= $k['deskripsi_kegiatan']; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= site_url('admin/delete_kegiatan'); ?>/<?= $k['id_kegiatan']; ?>" class="btn btn-danger swalHapus"><i class="fas fa-trash"></i></a>
                                    <a href="<?= site_url('admin/edit_kegiatan'); ?>/<?= $k['id_kegiatan']; ?>" class="btn btn-warning "><i class="fas fa-pen"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>