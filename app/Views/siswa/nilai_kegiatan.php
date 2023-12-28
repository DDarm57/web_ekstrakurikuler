<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>
<?php
function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split       = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
} ?>

<div class="container-fluid">
    <form action="">
        <div class="input-group mb-3">
            <input type="month" class="form-control" name="keyword" value="<?= (session()->getFlashdata('lastSearch') == true ? session()->getFlashdata('lastSearch') : date('Y-m')); ?>">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            <!-- /btn-group -->
        </div>
    </form>
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
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Materi</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($nilai as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['J_materi']; ?></td>
                            <td><?= $s['J_keterangan']; ?></td>
                            <td><?= Tanggal_indo($s['J_tanggal'], true); ?></td>
                            <td><?= $s['J_waktu']; ?></td>
                            <td><?= $s['nilai']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>