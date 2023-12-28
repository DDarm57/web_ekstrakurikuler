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

    <form action="">
        <div class="input-group mb-3">
            <select class="selectpicker" name="cariLevel" id="" class="form-control" data-container="body" data-live-search="true" title="Pilih Level">
                <option <?= (session()->getFlashdata('lastSearch') == 2 ? 'selected' : ''); ?> value="2">Pembina</option>
                <option <?= (session()->getFlashdata('lastSearch') == 3 ? 'selected' : ''); ?> value="3">Siswa</option>
            </select>
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            <!-- /btn-group -->
        </div>
    </form>

    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Users
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($users as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['username']; ?></td>
                            <td><?= $s['password']; ?></td>
                            <td>
                                <?php
                                if (session()->getFlashdata('lastSearch') == 2) {
                                    $nama = $s['nama_pembina'];
                                    $level = 'Pembina';
                                } elseif (session()->getFlashdata('lastSearch') == 3) {
                                    $nama = $s['nama_siswa'];
                                    $level = 'Siswa';
                                } else {
                                    $nama = $s['nama_siswa'];
                                    $level = 'Siswa';
                                }
                                ?>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-info" id="detailUsers" data-nama="<?= $nama; ?>" data-level="<?= $level; ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-info"></i></a>
                                    <a href="#" class="btn btn-warning" id="editUsers" data-id="<?= $s['id']; ?>" data-username="<?= $s['username']; ?>" data-password="<?= $s['password']; ?>" data-toggle="modal" data-target="#exampleModalEdit"><i class="fas fa-pen"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('admin/update_users'); ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="password" class="form-control">
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-detail">
                    <div class="form-group">
                        <label for="nama">Nama :</label>
                        <input type="text" class="form-control" name="nama" id="nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Level :</label>
                        <input type="text" class="form-control" name="level" id="level" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>



<?= $this->endSection(); ?>