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
                            <?= form_open_multipart( 'admin/edit-kuesioner/' .$id_kuesioner) ?>

                            <div class="form-group">
                                <label for="nama_kuesioner">Nama Kuesioner</label>
                                <input type="text" name="nama_kuesioner" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="id_wisata">Nama Wisata</label>
                                <?php  
                                    $w = [];
                                    foreach ( $wisata as $row ) $w[$row->id_wisata] = $row->nama_wisata;
                                    echo form_dropdown( 'id_wisata', $w, $kuesioner->id_wisata, [ 'class' => 'form-control', 'required' => 'required' ] );
                                ?>
                            </div>


                            <input type="submit" name="edit" value="Edit" class="btn btn-primary">

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