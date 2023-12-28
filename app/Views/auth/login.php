<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Ekstra | Log in</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition login-page" style="overflow-y: auto;">
    <?php if (session()->getFlashdata('pesan_logout')) : ?>
        <div class="swal" data-swal="<?= session()->getFlashdata('pesan_logout'); ?>"></div>
    <?php endif ?>

    <div class="">
        <img src="/assets/logo.png" alt="sman1pademawu.png" style="width: 80px;">
    </div>
    <div class="mb-2 text-center">
        <h2>Sitem Informasi<b> Ekstrakurikuler</b></h2>
        <h4>SMAN 1 PADEMAWU</h4>
    </div>

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1><b>Login</b></h1>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('pesan_hijau')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan_hijau'); ?>
                    </div>
                <?php endif ?>

                <?php if (session()->getFlashdata('pesan_merah')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('pesan_merah'); ?>
                    </div>
                <?php endif ?>

                <form action="<?= site_url('auth/cek_login'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </form>
                <!-- /.social-auth-links -->
                <div class="mt-2">
                    <a href="<?= site_url('auth/register'); ?>">Register</a>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>/template/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/template/dist/js/adminlte.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url(); ?>/template/plugins/toastr/toastr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url(); ?>/template/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function() {
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 4000);
        });

        const swal = $(".swal").data("swal");
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        if (swal) {
            Toast.fire({
                icon: 'success',
                title: 'Logout Berhasil!'
            });
        }
    </script>
</body>

</html>