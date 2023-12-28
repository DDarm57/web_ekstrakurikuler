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
        <!-- Button trigger modal -->
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Siswa Berdasarkan Kelas
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <form action="<?= site_url('admin/save_kenaikanKelas'); ?>" method="POST">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="" id="centangSemua"></th>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Pilihan Ekstra</th>
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
                                <td><?= $s['nama_kegiatan']; ?></td>
                                <input type="hidden" name="id_pembina" id="" value="<?= $s['id_pembina']; ?>">
                                <input type="hidden" name="id_kegiatan" id="" value="<?= $s['id_kegiatan']; ?>">
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="kelas">Tahun Akademik</label>
                            <select class="selectpicker form-control <?= ($validation->hasError('id_thnAkd')) ? 'is-invalid' : ''; ?>" name="id_thnAkd" data-container="body" data-live-search="true" title="Tahun Akademik Sekarang">
                                <?php foreach ($get_thnAkd as $g) : ?>
                                    <option value="<?= $g['id_thnAkd']; ?>"><?= $g['tahun']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('id_thnAkd'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="kelas">Kelas Sekarang</label>
                            <input type="text" value="<?= $kelas_now['nama_kelas']; ?>" id="" class="form-control" readonly>
                            <input type="hidden" name="kelas_now" value="<?= $kelas_now['id_kelas']; ?>" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="kelas">Naik Ke Kelas</label>
                            <select class="selectpicker form-control <?= ($validation->hasError('naik_kelas')) ? 'is-invalid' : ''; ?>" name="naik_kelas" data-container="body" data-live-search="true" title="Pilih Kelas">
                                <optgroup label="pilih ini jika tidak naik kelas">
                                    <option value="tidak_naik">tidak naik kelas</option>
                                </optgroup>
                                <?php foreach ($list_kelas as $k) : ?>
                                    <option value="<?= $k['id_kelas']; ?>"><?= $k['nama_kelas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $validation->getError('naik_kelas'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="kelas">Tahun</label>
                            <input type="month" name="tahun" class="form-control" value="<?= date('Y-m'); ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>