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

    <div class="row">
        <div class="col-6">
            <div class="mb-2">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Nilai</a>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-2 text-right">
                <a href="" class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> PDF</a>
                <a href="<?= site_url('pembina/setting_excel'); ?>" class="btn btn-outline-success"><i class="fas fa-file-excel"></i> Set Cetak Excel</a>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 col-6">
                    <i class="fas fa-table me-1"></i>
                    Data Nilai Siswa
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pembina/mdelete_nilai'); ?>" method="POST" class="mdeleteNilai">
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="btn btn-warning btn-sm" id="centangSemua"></th>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Kelas</th>
                            <th>nilai 1</th>
                            <th>nilai 2</th>
                            <th>nilai 3</th>
                            <th>nilai 4</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1 ?>
                        <?php foreach ($nilai as $s) : ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="id_nilai[]" class="centangIdNilai" value="<?= $s['id_nilai']; ?>">
                                </td>
                                <td><?= $n++; ?></td>
                                <td><?= $s['nis_siswa']; ?></td>
                                <td><?= $s['nama_siswa']; ?></td>
                                <td><?= $s['jk']; ?></td>
                                <td><?= $s['kelas']; ?></td>
                                <td><?= $s['nilai1']; ?></td>
                                <td><?= $s['nilai2']; ?></td>
                                <td><?= $s['nilai3']; ?></td>
                                <td><?= $s['nilai4']; ?></td>
                                <td>
                                    <a href="" class="btn btn-warning" id="Edit" data-toggle="modal" data-target="#editNilai" data-nilai_userid="<?= $s['nilai_userid']; ?>" data-nama_siswa="<?= $s['nama_siswa']; ?>" data-nilai1="<?= $s['nilai1']; ?>" data-nilai2="<?= $s['nilai2']; ?>" data-nilai3="<?= $s['nilai3']; ?>" data-nilai4="<?= $s['nilai4']; ?>"><i class="fas fa-pen"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger btn-sm hapusSemuaNilai">Hapus Semua</button>
            </form>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="editNilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('pembina/update_nilai'); ?>" method="POST">
                <div class="modal-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 id="nama_siswa"></h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="nilai_userid" id="nilai_userid">
                            <div class="form-row">
                                <div class="col">
                                    <label for="nilai1">Nilai 1</label>
                                    <input type="text" class="form-control" id="nilai1" name="nilai1">
                                </div>
                                <div class="col">
                                    <label for="nilai2">Nilai 2</label>
                                    <input type="text" class="form-control" id="nilai2" name="nilai2">
                                </div>
                                <div class="col">
                                    <label for="nilai3">Nilai 3</label>
                                    <input type="text" class="form-control" id="nilai3" name="nilai3">
                                </div>
                                <div class="col">
                                    <label for="nilai4">Nilai 4</label>
                                    <input type="text" class="form-control" id="nilai4" name="nilai4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('pembina/save_nilai'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kelas">Pilih NIS</label>
                        <select class="selectpicker form-control" name="nilai_userid" data-container="body" data-live-search="true" title="Pilih Kelas">

                            <?php foreach ($siswa as $k) : ?>
                                <option class="<?= ($k['status'] == 'belum validasi' ? 'text-danger' : 'text-success'); ?>" value="<?= $k['siswa_userid']; ?>">Nama : <?= $k['nama_siswa']; ?> | NIS : <?= $k['nis_siswa']; ?> | Status : <?= $k['status']; ?></option>
                            <?php endforeach; ?>
                        </select>
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

<?= $this->endSection(); ?>