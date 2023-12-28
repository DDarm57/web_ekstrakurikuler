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
    <div class="mb-2">
        <a href="<?= site_url('pembina/nilai_rata'); ?>" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalNilai"><i class="fas fa-calendar"></i> Cek Rata-rata nilai</a>
        <a href="<?= site_url('pembina/set_cetakNilai'); ?>" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-file-excel"></i> Cetak Nilai</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Siswa</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
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
                    <?php foreach ($murid as $s) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $s['nis_siswa']; ?></td>
                            <td><?= $s['nama_siswa']; ?></td>
                            <td><?= $s['jk']; ?></td>
                            <td><?= $s['alamat_siswa']; ?></td>
                            <td>
                                <a href="#" class="cekGambar" data-namasiswa="<?= $s['nama_siswa']; ?>" data-gambarsiswa="<img src='/assets/fotosiswa/<?= $s['gambar_siswa']; ?>' style='width:280px;'>" data-toggle="modal" data-target=".bd-example-modal-sm">Cek Gambar</a>
                            </td>
                            <td><a href="<?= site_url('pembina/detail_nilai'); ?>/<?= $s['id_siswa']; ?>" class="btn btn-warning">Detail Nilai</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak Nilai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('pembina/cek_nilai'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tahun Akademik</label>
                            <select class="selectpicker form-control" name="id_thnAkd" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                <?php if (old('id_thnAkd') == true) : ?>
                                    <optgroup label="pilihan sebelumnya">
                                        <option selected value="<?= old('id_thnAkd'); ?>"><?= old('id_thnAkd'); ?></option>
                                    </optgroup>
                                <?php endif; ?>
                                <?php foreach ($tahun_akd as $k) : ?>
                                    <option <?= ($k['status'] == 'aktif' ? 'selected' : ''); ?> value="<?= $k['id_thnAkd']; ?>"><?= $k['tahun']; ?> <?= ($k['status'] == 'aktif' ? 'aktif sekarang' : ''); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="J_bulan">Bulan</label>
                            <input type="month" name="J_bulan" id="J_bulan" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Cek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalNilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak Nilai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('pembina/nilai_rata'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tahun Akademik</label>
                            <select class="selectpicker form-control" name="id_thnAkd" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                <?php if (old('id_thnAkd') == true) : ?>
                                    <optgroup label="pilihan sebelumnya">
                                        <option selected value="<?= old('id_thnAkd'); ?>"><?= old('id_thnAkd'); ?></option>
                                    </optgroup>
                                <?php endif; ?>
                                <?php foreach ($tahun_akd as $k) : ?>
                                    <option <?= ($k['status'] == 'aktif' ? 'selected' : ''); ?> value="<?= $k['id_thnAkd']; ?>"><?= $k['tahun']; ?> <?= ($k['status'] == 'aktif' ? 'aktif sekarang' : ''); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="month" name="tahun" class="form-control" value="<?= date('Y-m'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Cek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal gambar siswa -->
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

</div>

<?= $this->endSection(); ?>