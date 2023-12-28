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
        <div class="input-group mb-2">
            <input type="month" class="form-control" name="keyword" value="<?= (session()->getFlashdata('lastSearch') == true ? session()->getFlashdata('lastSearch') : date('Y-m')); ?>">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            <!-- /btn-group -->
        </div>
    </form>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Detail Data Tahun Akademik
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Nama Pembina</th>
                        <th>Kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($akademik as $akd) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $akd['nis_siswa']; ?></td>
                            <td><?= $akd['nama_siswa']; ?></td>
                            <td><?= $akd['nama_kelas']; ?></td>
                            <td><?= $akd['nama_pembina']; ?></td>
                            <td><?= $akd['nama_kegiatan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>