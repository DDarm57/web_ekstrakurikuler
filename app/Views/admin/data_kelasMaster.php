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
        <a href="<?= site_url('admin/create_kegiatan'); ?>" class="btn btn-primary" data-toggle="modal" data-target="#tambahKelas">Tambah Data</a>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Kelas Master
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1 ?>
                    <?php foreach ($kelas as $k) : ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $k['nama_kelas']; ?></td>
                            <td>
                                <a href="<?= site_url('admin/detail_kelasMaster'); ?>/<?= $k['id_kelas']; ?>" class="btn btn-info swalDetailKelas"><i class="fas fa-info"></i></a>
                                <a href="<?= site_url('admin/delete_kelasMaster'); ?>/<?= $k['id_kelas']; ?>" class="btn btn-danger swalHapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('admin/save_kelasMaster'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Form Tambah Kelas</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Kelas</label>
                                            <select class="selectpicker form-control" name="kelas" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                                <?php if (old('kelas') == true) : ?>
                                                    <optgroup label="pilihan sebelumnya">
                                                        <option selected value="<?= old('kelas'); ?>"><?= old('kelas'); ?></option>
                                                    </optgroup>
                                                <?php endif; ?>
                                                <option value="X">X</option>
                                                <option value="XI">XI</option>
                                                <option value="XII">XII</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Jurusan</label>
                                            <select class="selectpicker form-control" name="jurusan" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                                <?php if (old('jurusan') == true) : ?>
                                                    <optgroup label="pilihan sebelumnya">
                                                        <option selected value="<?= old('jurusan'); ?>"><?= old('jurusan'); ?></option>
                                                    </optgroup>
                                                <?php endif; ?>
                                                <option value="IPA">IPA</option>
                                                <option value="MIPA">MIPA</option>
                                                <option value="IPS">IPS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Nomor</label>
                                            <select class="selectpicker form-control" name="nomor" data-container="body" data-live-search="true" title="Pilih Ekstra">
                                                <?php if (old('nomor') == true) : ?>
                                                    <optgroup label="pilihan sebelumnya">
                                                        <option selected value="<?= old('nomor'); ?>"><?= old('nomor'); ?></option>
                                                    </optgroup>
                                                <?php endif; ?>
                                                <?php for ($i = 1; $i <= 10; $i++) {
                                                    echo '<option value="' . $i . '">' . $i . '</option>;';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="mt-4">CONTOH :</h6>
                                <h6>Kelas = <strong>X</strong> + Jurusan = <strong>MIPA</strong> + Nomor = <strong>1</strong> Keluaran <strong>(X MIPA 1)</strong></h6>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>