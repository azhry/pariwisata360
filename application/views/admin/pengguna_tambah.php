        <!-- ============================================================== -->
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
                            <?= form_open_multipart( 'admin/tambah-pengguna' ) ?>

                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="text" name="tanggal_lahir" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="id_hak_akses">Hak Akses</label>
                                <select class="form-control" name="id_hak_akses" required>
                                    <option>Pilih Hak Akses</option>
                                    <?php foreach ( $hak_akses as $row ): ?>
                                    <option value="<?= $row->id_hak_akses ?>"><?= $row->label ?></option>
                                    <?php endforeach; ?>
                                </select>
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