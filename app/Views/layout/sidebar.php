<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

    <?php if (session()->get('level') == 1) : ?>

      <li class="nav-item">
        <a href="<?= site_url('admin/dashboard'); ?>" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-list"></i>
          <p>
            Siswa
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= site_url('admin/data_siswa'); ?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Data Siswa</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('admin/data_kelasMaster'); ?>" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Data Kelas Master</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="<?= site_url('admin/data_kelas'); ?>" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Data Kelas</p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="<?= site_url('admin/data_register'); ?>" class="nav-link">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>Register</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a href="<?= site_url('admin/data_pembina'); ?>" class="nav-link">
          <i class="nav-icon fas fa-user-tie"></i>
          <p>Data Pembina</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?= site_url('admin/data_kegiatan'); ?>" class="nav-link">
          <i class="nav-icon fas fa-running"></i>
          <p>Data Kegiatan</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?= site_url('admin/data_users'); ?>" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>Data Users</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?= site_url('admin/tahun_akademik'); ?>" class="nav-link">
          <i class="nav-icon fas fa-calendar"></i>
          <p>Tahun Akademik</p>
        </a>
      </li>

    <?php endif ?>

    <!-- Sidebar Pembina -->

    <?php if (session()->get('level') == 2) : ?>
      <li class="nav-item">
        <a href="<?= site_url('pembina/dashboard'); ?>" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('pembina/siswa'); ?>" class="nav-link">
          <i class="nav-icon fas fa-user"></i>
          <p>Siswa</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('pembina/jadwal_kegiatan'); ?>" class="nav-link">
          <i class="nav-icon fas fa-list"></i>
          <p>Jadwal Kegiatan</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('pembina/validasi_nilai'); ?>" class="nav-link">
          <i class="nav-icon fas fa-check"></i>
          <p>Validasi Nilai
            <?php
            $db = $this->db = \Config\Database::connect();

            $builder = $this->db->table('users');
            $builder->where('kegiatan', session()->get('kegiatan'));
            $builder->where('status', 'validasi nilai');
            $builder->where('level', 3);
            $get_count = $builder->countAllResults();

            // dd($get_count);
            if ($get_count  != 0) {
              echo '<span class="badge badge-danger right">' . $get_count . '</span>';
            }
            ?>
          </p>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a href="<?= site_url('pembina/daftar_info'); ?>" class="nav-link">
          <i class="nav-icon fas fa-bullhorn"></i>
          <p>Daftar Info</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('pembina/riwayat_nilai'); ?>" class="nav-link">
          <i class="nav-icon fas fa-history"></i>
          <p>Riwayat Nilai</p>
        </a>
      </li> -->

    <?php endif ?>


    <!-- Sidebar Siswa -->

    <?php if (session()->get('level') == 3) : ?>
      <li class="nav-item">
        <a href="<?= site_url('siswa/dashboard'); ?>" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('siswa/nilai_kegiatan'); ?>" class="nav-link">
          <i class="nav-icon fas fa-clipboard-list"></i>
          <p>Nilai</p>
        </a>
      </li>
    <?php endif; ?>

  </ul>
</nav>