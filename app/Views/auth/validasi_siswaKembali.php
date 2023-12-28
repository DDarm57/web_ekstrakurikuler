<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <link rel="stylesheet" href="<?= base_url(); ?>/bootstrap-select/dist/css/bootstrap-select.css">

    <title><?= $tittle; ?></title>
</head>

<body>
    <h1 class="m-4"><?= $tittle; ?></h1>
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card card-success m-4">
                <div class="card-header">
                    <h3 class="card-title">Form Lengkapi Data Siswa Kembali</h3>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('auth/update_validasiKembali'); ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_siswa" value="<?= $siswa->id_siswa; ?>">
                        <input type="hidden" name="gambarLama" value="<?= $siswa->gambar_siswa; ?>">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nis_siswa">Nis</label>
                                    <input class="form-control <?= ($validation->hasError('nis_siswa')) ? 'is-invalid' : ''; ?>" name="nis_siswa" id="nis_siswa" type="text" placeholder="nis siswa" value="<?= $siswa->nis_siswa; ?>" aria-readonly="true" readonly>
                                    <div class="invalid-feedback"><?= $validation->getError('nis_siswa'); ?></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama</label>
                                    <input class="form-control" name="nama_siswa" id="nama_siswa" type="text" placeholder="nama" value="<?= $siswa->nama_siswa; ?>">

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>Jenis Kelamin</label>
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="L" <?= ($siswa->jk) == 'L'  ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="P" <?= ($siswa->jk) == 'P'  ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="kelas">Kelas</label>
                                <div class="input-group mb-3">
                                    <!-- <button type="button" id="btnKelas" class="btn btn-primari">on</button> -->
                                    <select class="selectpicker form-control <?= ($validation->hasError('kelas')) ? 'is-invalid' : ''; ?>" name="kelas" data-container="body" data-live-search="true" title="Pilih Kelas">
                                        <?php if (old('kelas')) : ?>
                                            <optgroup label="pilihan Sebelumnya">
                                                <option value="<?= old('kelas'); ?>"><?= ($siswa->id_kelas == old('kelas') ? $siswa->nama_kelas : ''); ?></option>
                                            </optgroup>
                                        <?php endif; ?>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['id_kelas']; ?>"><?= $k['nama_kelas']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback"><?= $validation->getError('kelas'); ?></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="california">Pilihan Ekstra</label>
                                    <select class="selectpicker form-control <?= ($validation->hasError('pilihan_kegiatan')) ? 'is-invalid' : ''; ?>" name="pilihan_kegiatan" data-container="body" data-live-search="true" title="Pilih Kegiatan">
                                        <?php if (old('pilihan_kegiatan')) : ?>
                                            <optgroup label="pilihan Sebelumnya">
                                                <option value="<?= old('pilihan_kegiatan'); ?>"><?= ($siswa->id_kegiatan == old('pilihan_kegiatan') ? $siswa->nama_kegiatan : ''); ?></option>
                                            </optgroup>
                                        <?php endif; ?>
                                        <?php foreach ($kegiatan as $kg) : ?>
                                            <option <?= ($siswa->id_kegiatan == $kg['id_kegiatan'] ? 'selected' : ''); ?> value="<?= $kg['id_kegiatan']; ?>"><?= $kg['nama_kegiatan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_siswa">Alamat</label>
                            <input type="text" class="form-control" name="alamat_siswa" id="alamat_siswa" value="<?= $siswa->alamat_siswa; ?>">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">Tambah Gambar</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input <?= ($validation->hasError('gambar_siswa')) ? 'is-invalid' : ''; ?>" name="gambar_siswa" id="gambar_siswa" onchange="previewSiswaImg()">
                                    <label class="custom-file-label" for="customFile"><?= $siswa->gambar_siswa; ?></label>
                                    <div class="invalid-feedback"><?= $validation->getError('gambar_siswa'); ?></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mt-2">
                                    <img src="/assets/fotosiswa/<?= $siswa->gambar_siswa; ?>" class="img-thumbnail imgSiswa-preview" alt="default" style="width: 150px;">
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

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

    <script src="<?= base_url(); ?>/bootstrap-select/dist/js/bootstrap-select.js"></script>

    <script>
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
    </script>
</body>

</html>