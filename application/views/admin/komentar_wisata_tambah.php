<<<<<<< HEAD
<!-- ============================================================== -->
=======
        <!-- ============================================================== -->
>>>>>>> 1dec1cc80fbbf4b76af001866523bdf6c8156cdc
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?= $title ?></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?= base_url( 'admin' ) ?>">Dashboard</a></li>
                            <li class="active"><?= $title ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title"><?= $title ?></h3> 
                            
                            <?= $this->session->flashdata( 'msg' ) ?>
                            <?= form_open_multipart( 'admin/tambah-komentar-wisata' ) ?>

                            <div class="form-group">
                                <label for="id_wisata">Wisata</label>
                                <select class="form-control" name="id_wisata" required>
                                    <option>Pilih Wisata</option>
                                    <?php foreach ( $wisata as $row ): ?>
                                    <option value="<?= $row->id_wisata ?>"><?= $row->nama_wisata ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_pengguna">Pengguna</label>
                                <select class="form-control" name="id_pengguna" required>
                                    <option>Pilih Pengguna</option>
                                    <?php foreach ( $pengguna as $row ): ?>
                                    <option value="<?= $row->id_pengguna ?>"><?= $row->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="komentar">Komentar</label>
                                <textarea name="komentar" class="form-control" rows="5" placeholder="Tulis Komentar Disini" required></textarea>
                            </div>


                            <input type="submit" name="submit" value="Tambah" class="btn btn-primary">

                            <?= form_close() ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Ample Admin brought to you by wrappixel.com </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->