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
            Data Users
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Status Validasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['nis_siswa']; ?></td>
                            <td><?= $s['nama_siswa']; ?></td>
                            <td><?php
                                $builder->where('username', $s['nis_siswa']);
                                $cek_nilai = $builder->get()->getRowArray();
                                if ($cek_nilai['status'] == 'validasi nilai') {
                                    echo '<strong class="text-danger">Nilai Belum Divalidasi</strong>';
                                } elseif ($cek_nilai['status'] ==  'sudah validasi') {
                                    echo '<strong class="text-success">Nilai Sudah Divalidasi</strong>';
                                } elseif ($cek_nilai['status'] == 'validasi data kembali') {
                                    echo '<strong class="text-warning">Data belum di lengkapi</strong>';
                                }
                                ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= site_url('pembina/update_validasiNilai'); ?>/<?= $s['siswa_userid']; ?>" class="btn btn-success btn-sm validasinilai"><i class="fas fa-check"></i> Validasi Nilai</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>