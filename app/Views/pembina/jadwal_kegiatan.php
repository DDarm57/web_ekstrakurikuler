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
    <div class="d-flex flex-row">
        <div class="p-0">
            <a href="<?= site_url('pembina/create_jadwal'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</a>
        </div>
        <div class="pl-2">
            <form action="">
                <div class="input-group mb-3">
                    <input type="month" class="form-control" name="keyword" value="<?= (session()->getFlashdata('lastSearch') == true ? session()->getFlashdata('lastSearch') : date('Y-m')); ?>">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                    <!-- /btn-group -->
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Detail Tanggal</th>
                        <th>Materi</th>
                        <th>Waktu</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
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
                    <?php $n = 1 ?>
                    <?php foreach ($jadwal as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?php echo tanggal_indo($s['J_tanggal'], true); ?></td>
                            <td><?= $s['J_materi']; ?></td>
                            <td><?= $s['J_waktu']; ?></td>
                            <td><?= $s['J_keterangan']; ?></td>
                            <td>
                                <a href="<?= site_url('pembina/delete_jadwal'); ?>/<?= $s['id_jadwal']; ?>" class="btn btn-danger swalHapus"><i class="fas fa-trash"></i></a>
                                <a href="<?= site_url('pembina/edit_jadwal'); ?>/<?= $s['id_jadwal']; ?>" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<?= $this->endSection(); ?>