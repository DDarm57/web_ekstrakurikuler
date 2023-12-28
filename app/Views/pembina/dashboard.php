<?= $this->extend('layout/template'); ?>

<?= $this->Section('page-content'); ?>
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
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-4">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3><?= $get_siswa; ?></h3>
                    <p>Data Siswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="<?= site_url('pembina/siswa'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-sm-4">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $get_info; ?></h3>
                    <p>Nilai Tervalidasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <a href="<?= site_url('pembina/validasi_nilai'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-sm-4">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $get_notValidasi; ?></h3>
                    <p>Nilai Belum Validasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <a href="<?= site_url('pembina/validasi_nilai'); ?>" class="small-box-footer">Validasi Nilai <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
    </div>
    <div class="row">
        <!-- Map card -->
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Profile
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/fotopembina/<?= $pembina->gambar_pembina; ?>" alt="Admin" width="150">
                        <div class="mt-3">
                            <h4 class="text-dark"><?= $pembina->nama_pembina; ?></h4>
                            <p class="text-secondary mb-1">NIP : <?= $pembina->nip_pembina; ?></p>
                            <p class="text-muted font-size-sm"><?= $pembina->nama_kegiatan; ?></p>
                            <a href="<?= site_url('pembina/edit_profile'); ?>/<?= $pembina->id_pembina; ?>" class="btn btn-warning"><i class="fas fa-pen"></i> Edit</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-body-->
                <div class="card-footer bg-transparent">
                    <div class="row">
                        <div class="col-4 text-center">
                            <div id="sparkline-1"></div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4 text-center">
                            <div id="sparkline-2"></div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4 text-center">
                            <div id="sparkline-3"></div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-sm-6">
            <!-- Calendar -->
            <div class="card bg-info">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="far fa-calendar-alt"></i>
                        Kalender
                    </h3>
                    <!-- tools card -->
                    <div class="card-tools">
                        <button type="button" class="btn btn-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                    <!--The calendar -->
                    <div id="calendar" style="width: 100%"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
<?= $this->endSection(); ?>