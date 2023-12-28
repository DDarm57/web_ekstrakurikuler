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
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Nilai Siswa</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="alert alert-info mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Info!!</strong> Centang data kemudian isi nilai dan simpan data
                    </div>
                    <form action="">
                        <div class="input-group mb-3">
                            <input type="month" class="form-control" name="keyword" value="<?= (session()->getFlashdata('lastSearch') == true ? session()->getFlashdata('lastSearch') : date('Y-m')); ?>">
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                            <!-- /btn-group -->
                        </div>
                    </form>
                    <form action="<?= site_url('pembina/update_nilai'); ?>" method="POST">
                        <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa']; ?>">
                        <table id="" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input saklar" id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1"></label>
                                        </div>
                                    </th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Materi</th>
                                    <th scope="col">Nilai</th>
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
                                <?php $no = 1; ?>
                                <?php foreach ($nilai as $n) : ?>
                                    <?php $nomer = $no++; ?>
                                    <tr>
                                        <td>
                                            <input type="radio" name="id_nilai[]" class="centangIdNilai<?= $nomer; ?> nilaiSaklar" value="<?= $n['id_nilai']; ?>" disabled>
                                        </td>
                                        <td><?= tanggal_indo($n['J_tanggal'], true); ?></td>
                                        <td><?= $n['J_materi']; ?></td>
                                        <td>
                                            <input type="text" id="nilai<?= $nomer; ?>" value="<?= $n['nilai']; ?>" name="nilai" class="form-control nilaiInput" style="width: 80px;" disabled>
                                        </td>
                                    </tr>
                                    <?php $last_number = $nomer; ?>
                                <?php endforeach; ?>
                                <p id="no_perulangan" data-no_perulangan="<?= $last_number; ?>"></p>
                            </tbody>
                        </table>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-success btn-sm">Simpan Nilai</button>
                        </div>
                    </form>
                </div>
                <div class="m-2">
                    <a href="<?= site_url('pembina/siswa'); ?>">Kembali</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Profile Siswa
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/fotosiswa/<?= $siswa['gambar_siswa']; ?>" class="img-thumbnail" alt="Admin" width="150">
                        <div class="mt-3">
                            <h4 class="text-dark"><?= $siswa['nis_siswa']; ?></h4>
                            <p class="text-secondary mb-1">Nama : <?= $siswa['nama_siswa']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>