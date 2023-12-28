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
        <?php if (session()->getFlashdata('pesan_reset')) : ?>
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Reset Data</h4>
                <p>Apakah anda yakin akan merest data? jika ya maka data yang di aktifkan sebelumnya akan di reset ulang semua data yang ada di data akademik akan di hapus</p>
                <form action="<?= site_url('admin/reset_thnAkd'); ?>">
                    <input type="hidden" name="id_thnAkd" value="<?= session()->setFlashdata('pesan_merah'); ?>">
                    <button type="submit" class="btn btn-danger">Reset</button>
                </form>
            </div>
        <?php endif ?>
    </div>

    <div class="mb-2">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Tahun Akademik</a>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Tahun Akademik
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($tahun as $t) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $t['tahun']; ?></td>
                            <td>
                                <strong>
                                    <p class="<?= ($t['status'] == 'aktif' ? 'text-success' : 'text-danger'); ?>"><?= $t['status']; ?></p>
                                </strong>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= site_url('admin/setting_thnAkd'); ?>/<?= $t['id_thnAkd']; ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Aktifkan</a>
                                    <a href="<?= site_url('admin/detail_thnAkd'); ?>/<?= $t['id_thnAkd']; ?>" class="btn btn-info btn-sm"><i class="fas fa-info"></i> Detail Akademik</a>
                                    <a href="" class="btn btn-warning btn-sm" data-toggle="modal" id="edit_tahun" data-id_thn="<?= $t['id_thnAkd']; ?>" data-tahun="<?= $t['tahun']; ?>" data-target="#exampleModalEdit"><i class="fas fa-pen"></i></a>
                                    <a href="<?= site_url('admin/delete_thnAkd'); ?>/<?= $t['id_thnAkd']; ?>" class="btn btn-danger btn-sm delete_thnAkd" data-tahun_akd="<?= $t['tahun']; ?>"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    Modal
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tahun Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('admin/save_thnAkd'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tahun1">Tahun 1</label>
                                    <select class="selectpicker form-control" name="tahun1" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                        <?php for ($i = 20; $i <= 30; $i++) {
                                            echo '<option value="' . 20 . $i . '">' . '20' . $i . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tahun1">Tahun 2</label>
                                    <select class="selectpicker form-control" name="tahun2" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                        <?php for ($i = 20; $i <= 30; $i++) {
                                            echo '<option value="' . 20 . $i . '">' . '20' . $i . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
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

    <!-- Modal Edit thn_Akd -->
    <div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Tahun Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('admin/update_thnAkd'); ?>" method="POST">
                    <div class="modal-body modal-edit">
                        <input type="hidden" name="id_thnAkd" id="id_thnAkd">
                        <label for="">Tahun</label>
                        <input type="text" class="form-control" name="tahun" id="nama_tahun">
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