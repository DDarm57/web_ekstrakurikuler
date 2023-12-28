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

    <?php if (session()->getFlashdata('pesan_confirm')) : ?>
        <div class="alert alert-warning" role="alert">
            <?= session()->getFlashdata('pesan_confirm'); ?>
            <form action="<?= site_url('admin/reset_siswa'); ?>">
                <input type="hidden" name="reset" id="" value="reset">
                <button type="submit" class="btn btn-danger btn-sm">Ya Reset Sekarang</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('pesan_reset')) : ?>
        <div class="alert alert-warning" role="alert">
            <?= session()->getFlashdata('pesan_reset'); ?>
            <a href="<?= site_url('admin/kembalikan_ulang'); ?>" class="btn btn-danger mt-2">Kembalikan Ulang</a>
        </div>
    <?php endif; ?>
    <div class="mb-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i> Buat Register Siswa
        </button>
        <a href="<?= site_url('admin/reset_siswa'); ?>" class="btn btn-warning reset-data"><i class="fas fa-redo"></i> Reset</a>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Users Register
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($users as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['username']; ?></td>
                            <td><?= ($s['password'] == null ? '<p class="text-danger">Data belum di lengkapi</p>' : $s['password']); ?></td>
                            <td><?= ($s['kegiatan'] == null ? '<p class="text-danger">Data belum di lengkapi</p>' : $s['nama_kegiatan']); ?></td>
                            <td><strong class="<?= ($s['status'] == 'sudah validasi' ? 'text-success' : 'text-danger'); ?>"><?= $s['status']; ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Masukan NISN sebagai metode pendaftaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('admin/save_register'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Nis</label>
                            <input type="text" name="username" id="" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>



<?= $this->endSection(); ?>