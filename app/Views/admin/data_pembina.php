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
    <div class="mb-2">
        <a href="<?= site_url('admin/create_pembina'); ?>" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah Data Pembina</a>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Setting Data Pembina
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <form action="<?= site_url('admin/mdelete_pembina'); ?>" method="POST">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Mengajar</th>
                            <th>No Telp</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1 ?>
                        <?php foreach ($pembina as $p) : ?>
                            <tr>
                                <td><?= $n++; ?></td>
                                <td><?= $p['nip_pembina']; ?></td>
                                <td><?= $p['nama_pembina']; ?></td>
                                <td><?= $p['alamat']; ?></td>
                                <td><?= $p['nama_kegiatan']; ?></td>
                                <td><?= $p['telp_pembina']; ?></td>
                                <td>
                                    <img src="/assets/fotopembina/<?= $p['gambar_pembina']; ?>" alt="<?= $p['gambar_pembina']; ?>" style="width: 100px;">
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/delete_pembina'); ?>/<?= $p['pembina_userid']; ?>" class="btn btn-danger swalHapus"><i class="fas fa-trash"></i></a>
                                    <a href="<?= site_url('admin/edit_pembina'); ?>/<?= $p['pembina_userid']; ?>" class="btn btn-warning"><i class="fas fa-pen"></i></a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <div class="mt-2">
                    <button type="submit" class="btn btn-danger btn-sm">Hapus semua data</button>
                </div> -->
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>