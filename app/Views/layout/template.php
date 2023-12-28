<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $tittle; ?></title>

  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap 4 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/daterangepicker/daterangepicker.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <link rel="stylesheet" href="<?= base_url(); ?>/bootstrap-select/dist/css/bootstrap-select.css">

  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <style>
      .loader {
        border: 16px solid #f3f3f3;
        /* Light grey */
        border-top: 16px solid #3498db;
        border-bottom: 16px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }

        100% {
          transform: rotate(360deg);
        }
      }
    </style>

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <div class="loader"></div>
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->
      </ul>
      <a href="<?= site_url('auth/logout'); ?>" class="btn btn-danger btn-logout">Logout</a>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a target="_blank" href="https://www.sman1pademawu.sch.id/" class="brand-link">
        <img src="/assets/sman1pademawu.png" alt="AdminLTE Logo" class="brand-image img-circle">
        <span class="brand-text font-weight-light">SMAN 1 PADEMAWU</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/assets/user.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <?php if (session()->get('level') == 1) : ?>
              <a href="<?= site_url('home/index'); ?>" class="d-block">Admin</a>
            <?php endif ?>
            <?php if (session()->get('level') == 2) : ?>
              <a href="<?= site_url('home/index'); ?>" class="d-block">Pembina</a>
            <?php endif ?>
            <?php if (session()->get('level') == 3) : ?>
              <a href="<?= site_url('home/index'); ?>" class="d-block">Siswa</a>
            <?php endif ?>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <?= $this->include('layout/sidebar'); ?>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $tittle; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= site_url('home/index'); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $tittle; ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <?= $this->renderSection('page-content'); ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="<?= base_url(); ?>/template/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url(); ?>/template/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url(); ?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= base_url(); ?>/template/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="<?= base_url(); ?>/template/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="<?= base_url(); ?>/template/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?= base_url(); ?>/template/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?= base_url(); ?>/template/plugins/moment/moment.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url(); ?>/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?= base_url(); ?>/template/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url(); ?>/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>/template/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- Select2 -->
  <script src="<?= base_url(); ?>/template/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?= base_url(); ?>/template/dist/js/pages/dashboard.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url(); ?>/template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="<?= base_url(); ?>/template/js/datatables-simple-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
  <script src="<?= base_url(); ?>/bootstrap-select/dist/js/bootstrap-select.js"></script>
  <!-- Toastr -->
  <script src="<?= base_url(); ?>/template/plugins/toastr/toastr.min.js"></script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
      $('.toastrDefaultSuccess').click(function() {
        toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });
      // $(document).ready(function() {
      //   window.setTimeout(function() {
      //     $(".alert").fadeTo(500, 0).slideUp(500, function() {
      //       $(this).remove();
      //     });
      //   }, 4000);
      // });
    });

    function previewSiswaImg() {
      const gambar_siswa = document.querySelector('#gambar_siswa');
      const gambar_siswaLabel = document.querySelector('.custom-file-label');
      const imgSiswaPreview = document.querySelector('.imgSiswa-preview');

      gambar_siswaLabel.textContent = gambar_siswa.files[0].name;

      const fileGambarSiswa = new FileReader();
      fileGambarSiswa.readAsDataURL(gambar_siswa.files[0]);

      fileGambarSiswa.onload = function(e) {
        imgSiswaPreview.src = e.target.result;
      }
    }

    function previewPembinaImg() {
      const gambar_pembina = document.querySelector('#gambar_pembina');
      const gambar_pembinaLabel = document.querySelector('.custom-file-label');
      const imgPembinaPreview = document.querySelector('.imgPembina-preview');

      gambar_pembinaLabel.textContent = gambar_pembina.files[0].name;

      const fileGambarPembina = new FileReader();
      fileGambarPembina.readAsDataURL(gambar_pembina.files[0]);

      fileGambarPembina.onload = function(e) {
        imgPembinaPreview.src = e.target.result;
      }
    }

    function previewInfoImg() {
      const gambar_pembina = document.querySelector('#gambar_info');
      const gambar_pembinaLabel = document.querySelector('.custom-file-label');
      const imgPembinaPreview = document.querySelector('.imgInfo-preview');

      gambar_pembinaLabel.textContent = gambar_pembina.files[0].name;

      const fileGambarPembina = new FileReader();
      fileGambarPembina.readAsDataURL(gambar_pembina.files[0]);

      fileGambarPembina.onload = function(e) {
        imgPembinaPreview.src = e.target.result;
      }
    }
  </script>
  <script>
    $(function() {
      // Summernote
      $('#summernote').summernote()

      // CodeMirror
      CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
      });
    })
  </script>


  <!-- Jquery -->
  <script>
    //edit users
    $(document).on("click", "#editUsers", function() {
      let id = $(this).data('id');
      let username = $(this).data('username');
      let password = $(this).data('password')

      $('.modal-body #id').val(id);
      $('.modal-body #username').val(username);
      $('.modal-body #password').val(password);
    });

    // detail users
    $(document).on('click', '#detailUsers', function() {
      let nama = $(this).data('nama');
      let level = $(this).data('level');

      $(".modal-detail #nama").val(nama);
      $(".modal-detail #level").val(level);
    })
  </script>

  <!-- Detail Kelas Jquery -->
  <script>
    $(document).on("click", "#kelasDetail", function() {
      let nama_kelas = $(this).data('nama_kelas');
      $(".modal-footer #nama_kelas").val(nama_kelas);
      $(".modal-body #nama_kelas").text(nama_kelas);
    })
  </script>

  <!-- Sweet allert -->
  <script>
    const swal = $(".swal").data("swal");
    if (swal) {
      Swal.fire(
        'Berhasil!',
        swal,
        'success'
      )
    }

    const swalGagal = $(".swalGagal").data("swalgagal");
    if (swalGagal) {
      Swal.fire(
        'Gagal!',
        swalGagal,
        'error'
      )
    }

    console.log(swal);

    $(document).on("click", ".swalHapus", function(e) {
      e.preventDefault();
      const href = $(this).attr('href')
      Swal.fire({
        title: 'Data akan dihapus!',
        text: "Apakah anda yakin ingin menghapus data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya hapus data',
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
    });

    $(document).on("click", ".validasinilai", function(e) {
      e.preventDefault();
      const href = $(this).attr('href')
      Swal.fire({
        title: 'Data akan divalidasi',
        text: "Apakah anda yakin ingin memvalidasi nilai",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya validasi nilai',
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
    });

    $(document).on("click", ".reset-data", function(e) {
      e.preventDefault();
      const href = $(this).attr('href')
      Swal.fire({
        title: 'Data akan direset',
        text: "Apakah anda yakin ingin mereset data? form ini berfungsi untuk siswa melakukan validasi data kembali",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya reset data',
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
    });

    //delete_thnAkd
    $(document).on('click', '.delete_thnAkd', function(e) {
      e.preventDefault();
      const href = $(this).attr('href')
      let tahun = $(this).data('tahun_akd');
      Swal.fire({
        title: 'Data akan dihapus!',
        text: 'Tahun akademik ' + tahun + ' akan dihapus. Apakah anda yakin?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya hapus data',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
    })

    //Edit thnAkd
    $(document).on('click', '#edit_tahun', function() {
      let id_thnAkd = $(this).data('id_thn');
      let nama_tahun = $(this).data('tahun');

      $('.modal-edit #id_thnAkd').val(id_thnAkd);
      $('.modal-edit #nama_tahun').val(nama_tahun);
    })

    $(document).on("click", ".swalDetailKelas", function(e) {
      e.preventDefault();
      const href = $(this).attr('href')
      Swal.fire({
        title: 'Info!',
        text: "Form ini berfungsi sebagai kenaikan kelas siswa apakah anda yakin akan menggunakan form ini? jika yakin klik detail.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6495ED',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Detail',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
    });

    $(document).on("click", ".swalHapusUsers", function(e) {
      e.preventDefault();
      const href = $(this).attr('href')
      Swal.fire({
        title: 'Data akan dihapus!',
        text: "Data Akan menghapus Secara keseluruhan yang terhubung dengan users. Apakah anda yakin?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya hapus data',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
    });

    $(document).on("click", ".btn-logout", function(e) {
      e.preventDefault();
      const href = $(this).attr('href')
      Swal.fire({
        title: 'Apakah anda yakin ingin logout?',
        text: "Cek kembali data. jika yakin klik logout dibawah!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Logout'
      }).then((result) => {
        if (result.isConfirmed) {
          let timerInterval
          Swal.fire({
            title: 'Sedang Logout!',
            html: 'Logout dalam <b></b> milidetik.',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              document.location.href = href
            }
          })
        }
      })
    });
  </script>

  <!-- multiple delete -->

  <script>
    // delete nilai

    $(document).ready(function() {
      $(".btnKelas").click(function(e) {
        if ($(this).is(':checked')) {
          $("#editKelas").prop('disabled', false);
        } else {
          $("#editKelas").prop('disabled', true);
        }
      });


      // $("#centangSemua").click(function(e) {
      //   if ($(this).is(':checked')) {
      //     $('.centangIdNilai').prop('checked', true);
      //   } else {
      //     $('.centangIdNilai').prop('checked', false);
      //   }
      // });
      let no_perulangan = $('#no_perulangan').data('no_perulangan');
      for (var i = 1; i <= no_perulangan; i++) {
        $('.centangIdNilai' + i).click(function() {
          for (var i = 1; i <= no_perulangan; i++) {
            if ($('.centangIdNilai' + i).is(':checked')) {
              $('#nilai' + i).prop('disabled', false);
            } else {
              $('#nilai' + i).prop('disabled', true);
            }
          }
        })
      }

      for (var i = 1; i <= no_perulangan; i++) {
        $('.centangIdNilai' + i).click(function() {
          for (var i = 1; i <= no_perulangan; i++) {
            if ($('.centangIdNilai' + i).is(':checked')) {
              $('#nilai' + i).prop('disabled', false);
            } else {
              $('#nilai' + i).prop('disabled', true);
            }
          }
        })
      }

      $(document).on('click', '.saklar', function() {
        if ($(this).is(':checked')) {
          $(".nilaiSaklar").prop('disabled', false);
        } else {
          $(".nilaiSaklar").prop('disabled', true);
          $(".nilaiSaklar").prop('checked', false);
          $(".nilaiInput").prop('disabled', true);

        }
      })
    });
  </script>

  <!-- Pesan toast -->
  <script>
    const toastHome = $(".toastHome").data("toasthome");
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    //Toast Home
    if (toastHome) {
      Toast.fire({
        icon: 'success',
        title: toastHome
      });
    }

    // pesan toastS

    const toastsHijau = $(".toastsHIjau").data("toastshijau");
    const toastsMerah = $(".toastsMErah").data("toastsmerah");
    if (toastsHijau) {
      for (var i = 1; i <= toastsHijau; i++) {
        $(document).Toasts("create", {
          class: "bg-success",
          title: "Berhasil Dihapus",
          subtitle: "Subtitle",
          body: "data berhasil di hapus",
        });
      }
    }
    if (toastsMerah) {
      for (var i = 1; i <= toastsMerah; i++) {
        $(document).Toasts("create", {
          class: "bg-danger",
          title: "Gagal Dihapus",
          subtitle: "Subtitle",
          body: "data gagal di hapus karena terhubung dengan data akademik",
        });
      }
    }
  </script>

  <script>
    $(function() {
      var url = window.location;
      // for single sidebar menu
      $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
      }).addClass('active');

      // for sidebar menu and treeview
      $('ul.nav-treeview a').filter(function() {
          return this.href == url;
        }).parentsUntil(".nav-sidebar > .nav-treeview")
        .css({
          'display': 'block'
        })
        .addClass('menu-open').prev('a')
        .addClass('active');
    });
  </script>

</body>

</html>