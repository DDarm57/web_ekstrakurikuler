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
            <i class="fas fa-table me-1"></i>
            Data Rata Rata Nilai
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Nilai Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['nis_siswa']; ?></td>
                            <td><?= $s['nama_siswa']; ?></td>
                            <?php
                            $nilai_rata->where('id_siswa', $s['id_siswa']);
                            $nilai_rata->selectAvg('nilai');
                            $cek_rata = $nilai_rata->get()->getRowArray(); ?>
                            <td><?= $cek_rata['nilai']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>