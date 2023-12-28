<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <?php if (session()->getFlashdata('pesan_hijau')) : ?>
        <div class="alert alert-success mb-2" role="alert">
            <?= session()->getFlashdata('pesan_hijau'); ?>
        </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('pesan_merah')) : ?>
        <div class="alert alert-danger mb-2" role="alert">
            <?= session()->getFlashdata('pesan_merah'); ?>
        </div>
    <?php endif ?>
    <div class="mb-2">
        <a href="<?= site_url('pembina/create_info'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Info</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Info</th>
                        <th>Tanggal</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($info as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['judul_info']; ?></td>
                            <td><?= $s['tanggal_info']; ?></td>
                            <td>
                                <img src="/assets/fotoinfo/<?= $s['gambar_info']; ?>" alt="" style="width: 150px;">
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= site_url('pembina/edit_info'); ?>/<?= $s['id_info']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                    <a href="<?= site_url('pembina/hapus_info'); ?>/<?= $s['id_info']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin menghapus')"><i class="fas fa-trash"></i></a>
                                    <a href="<?= site_url('pembina/detail_info'); ?>/<?= $s['id_info']; ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Judul Info</th>
                        <th>Tanggal</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?= $this->endSection(); ?>