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
        <?php if (session()->getFlashdata('pesan_ubahKelas')) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Info!!!</strong> <?= session()->getFlashdata('pesan_ubahKelas'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>

        <?php if (session()->getFlashdata('pesan_hapus')) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Info!!!</strong>
                <br>
                data siswa dengan nis terhubung dengan data akademik apakah anda yakin akan menghapusnya? jika ya.. maka data akan menghapus seluruh data yang ada di dalam data akademik
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form action="hapus_paksaSiswa">
                    <input type="hidden" name="id_siswa" value="<?= session()->getFlashdata('pesan_hapus'); ?>">
                    <button type="submit" class="btn btn-danger">Ya. Hapus Data</button>
                </form>
            </div>
        <?php endif ?>
    </div>

    <div class="mb-2">
        <?php if (session()->getFlashdata('toastsMerah')) : ?>
            <div class="toastsMErah" data-toastsmerah="<?= session()->getFlashdata('toastsMerah'); ?>"></div>
        <?php endif ?>
        <?php if (session()->getFlashdata('toastsHijau')) : ?>
            <div class="toastsHIjau" data-toastshijau="<?= session()->getFlashdata('toastsHijau'); ?>"></div>
        <?php endif ?>
    </div>

    <div class="mb-2">
        <div class="row">
            <div class="col">
                <a href="<?= site_url('admin/create_siswa'); ?>" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah Data Siswa</a>
            </div>
            <div class="col">
                <div class="text-right">
                    <a href="<?= site_url('admin/import_excel'); ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Import Excel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Setting Data Siswa
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <form action="<?= site_url('admin/mdelete_siswa'); ?>" method="POST">
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="" id="centangSemua"></th>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Alamat</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1 ?>
                        <?php foreach ($siswa as $s) : ?>
                            <tr>
                                <td><input type="checkbox" name="id_siswa[]" class="centangIdNilai" value="<?= $s['id_siswa']; ?>"></td>
                                <td><?= $n++; ?></td>
                                <td><?= $s['nis_siswa']; ?></td>
                                <td><?= $s['nama_siswa']; ?></td>
                                <td><?= $s['jk']; ?></td>
                                <td><?= $s['alamat_siswa']; ?></td>
                                <td>
                                    <a href="#" class="cekGambar" data-namasiswa="<?= $s['nama_siswa']; ?>" data-gambarsiswa="<img src='/assets/fotosiswa/<?= $s['gambar_siswa']; ?>' style='width:280px;'>" data-toggle="modal" data-target=".bd-example-modal-sm">Cek Gambar</a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= site_url('admin/delete_siswa'); ?>/<?= $s['siswa_userid']; ?>" class="btn btn-danger swalHapus"><i class="fas fa-trash"></i></a>
                                        <a href="<?= site_url('admin/edit_siswa'); ?>/<?= $s['siswa_userid']; ?>" class="btn btn-warning" data-swal="data siswa"><i class="fas fa-pen"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="mt-2">
                    <button type="submit" class="btn btn-danger btn-sm">Hapus semua data</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-sm" id="exampleModalGambar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="namaSiswa"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-gambar d-flex justify-content-center">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>