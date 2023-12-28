<?= $this->extend('layout/template'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $users; ?></h3>

          <p>Data Users</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
        <a href="<?= site_url('admin/data_users'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $count_siswa; ?><sup style="font-size: 20px"></sup></h3>

          <p>Data Siswa</p>
        </div>
        <div class="icon">
          <i class="fas fa-user"></i>
        </div>
        <a href="<?= site_url('admin/data_siswa'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $pembina; ?></h3>

          <p>Data Pembina</p>
        </div>
        <div class="icon">
          <i class="fas fa-user-tie"></i>
        </div>
        <a href="<?= site_url('admin/data_pembina'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $kegiatan; ?></h3>

          <p>Data Kegiatan</p>
        </div>
        <div class="icon">
          <i class="fas fa-running"></i>
        </div>
        <a href="<?= site_url('admin/data_kegiatan'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
</div><!-- /.container-fluid -->
<?= $this->endSection(); ?>