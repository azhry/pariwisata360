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
                            <li><a href="<?= base_url( 'admin/tambah-wisata' ) ?>">Dashboard</a></li>
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
                            <?= form_open_multipart( 'admin/tambah-wisata' ) ?>

                            <div class="form-group">
                                <label for="nama_wisata">Nama Wisata</label>
                                <input type="text" name="nama_wisata" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="deskripsi" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <?php echo form_open_multipart('upload/aksi_upload');?>
                                <label for="foto">Foto</label>
                                <input type="file" name="berkas" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" name="latitude" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" name="longitude" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="created_at">Created_at</label>
                                <input type="date" name="created_at" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="updated_at">Updated_at</label>
                                <input type="date" name="updated_at" class="form-control" required>
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