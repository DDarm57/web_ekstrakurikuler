<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Ekstra | Registration</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/bootstrap-select/dist/css/bootstrap-select.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href=""><b>Pendaftaran</b> Ekstrakurikuler SMAN 1 PADEMAWU</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Daftar untuk bisa mengakses</p>

                <?php if (session()->getFlashdata('pesan_merah')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('pesan_merah'); ?>
                    </div>
                <?php endif ?>

                <form action="<?= site_url('auth/save_register'); ?>" method="POST">
                    <div class="input-group mb-3">
                        <input type="number" name="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" placeholder="NIS">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                    </div>
                    <div class="input-group mb-3">
                        <select class="selectpicker form-control <?= ($validation->hasError('kegiatan')) ? 'is-invalid' : ''; ?>" name="kegiatan" data-container="body" data-live-search="true" title="Pilih Ekstra">
                            <?php if (old('kegiatan') == true) : ?>
                                <optgroup label="pilihan sebelumnya">
                                    <option selected value="<?= old('kegiatan'); ?>"><?= old('kegiatan'); ?></option>
                                </optgroup>
                            <?php endif; ?>
                            <?php foreach ($kegiatan as $k) : ?>
                                <option value="<?= $k['id_kegiatan']; ?>"><?= $k['nama_kegiatan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-running"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('kegiatan'); ?></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                </form>

                <p>Sudah mempunyai akun ? Silahkan<a href="<?= site_url('auth/login'); ?>" class="text-center"> Login</a></p>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>/template/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/template/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url(); ?>/bootstrap-select/dist/js/bootstrap-select.js"></script>
</body>

</html>