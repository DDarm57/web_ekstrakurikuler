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
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>L/P</th>
                        <th>Alamat</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($murid as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['nis_siswa']; ?></td>
                            <td><?= $s['nama_siswa']; ?></td>
                            <td><?= $s['jk']; ?></td>
                            <td><?= $s['alamat_siswa']; ?></td>
                            <td>
                                <img src="/assets/fotosiswa/<?= $s['gambar_siswa']; ?>" alt="<?= $s['gambar_siswa']; ?>" style="width: 100px;">
                            </td>
                            <td><a href="<?= site_url('pembina/detail_nilai'); ?>/<?= $s['id_siswa']; ?>" class="btn btn-warning">Detail Nilai</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>