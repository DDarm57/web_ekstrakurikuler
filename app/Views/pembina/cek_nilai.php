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
    <?php if (session()->getFlashdata('pesan_hijau')) : ?>
        <div class="alert alert-success mb-2" role="alert">
            <?= session()->getFlashdata('pesan_hijau'); ?>
        </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('pesan_merah')) : ?>
        <div class="alert alert-danger mb-2" role="alert">
            <?= session()->getFlashdata('pesan_merah'); ?>
        </div>
    <?php endif ?>
    <div class="mb-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-file-excel"></i> Cetak Nilai
        </button>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nilai Siswa</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">nama</th>
                        <th colspan="<?= $count; ?>" style="text-align: center; vertical-align: middle;"><?= ($bulan == 'tidak ada data' ? 'Tidak ada jadwal' : date('m', strtotime($bulan))); ?></th>
                    </tr>
                    <tr>
                        <?php if ($jadwal != null) : ?>
                            <?php foreach ($jadwal as $j) : ?>
                                <th style="text-align: center; vertical-align: middle;"><?php echo tanggal_indo($j['J_tanggal'], true); ?></th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ($jadwal == null) : ?>
                            <th>Tidak ada jadwal</th>
                            <th>Tidak ada jadwal</th>
                            <th>Tidak ada jadwal</th>
                            <th>Tidak ada jadwal</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 1;
                    foreach ($cek_siswa->getResult() as $cek) {
                        echo '<tr>
			        <td>' . $n++ . '</td>
			        <td>' . $cek->nama_siswa . ($cek->status == 'validasi nilai' ? ' <strong class="text-danger">(nilai belum di validasi)</strong>' : '') . '</td>';

                        foreach ($get_nilai->getResult() as $row) {
                            if ($cek->id_siswa != $row->id_siswa) {
                                continue;
                            }
                            if ($row->nilai == null) {
                                echo '<td>Nilai belum di input</td>';
                            } elseif ($row->nilai != null) {
                                echo '<td style="text-align: center; vertical-align: middle;">' . $row->nilai . '</td>';
                            }
                            // echo $row->J_keterangan . ' Nilai = ' . $row->nilai;
                        }
                        echo '</tr>';
                        // echo 'Jadwal Kegiatan : ';
                        // echo $row->J_materi;
                    } ?>
                </tbody>
            </table>
            <div class="m-2">
                <a href="<?= site_url('pembina/siswa'); ?>"><i class="fas fa-angle-left"></i> Kembali</a>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Setting Tanggal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('pembina/excel'); ?>" method="POST">
                    <input type="hidden" name="J_bulan" id="" value="<?= $bulan; ?>">
                    <div class="modal-body">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Simpan Excel</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <select class="selectpicker form-control" name="tanggal" data-container="body" data-live-search="true" title="pilih tanggal">
                                                <?php for ($i = 1; $i <= 31; $i++) {
                                                    echo '<option value="' . $i . '">' . $i . '</option>;';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Bulan</label>
                                            <select class="selectpicker form-control" name="bulan" data-container="body" data-live-search="true" title="Pilih Bulan">
                                                <option value="Januari">Januari</option>
                                                <option value="Februari">Februari</option>
                                                <option value="Maret">Maret</option>
                                                <option value="April">April</option>
                                                <option value="Mei">Mei</option>
                                                <option value="Juni">Juni</option>
                                                <option value="Juli">Juli</option>
                                                <option value="Agustus">Agustus</option>
                                                <option value="September">September</option>
                                                <option value="Oktober">Oktober</option>
                                                <option value="November">November</option>
                                                <option value="Desember">Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Tahun</label>
                                            <input type="text" name="tahun" class="form-control" value="<?= date('Y'); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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