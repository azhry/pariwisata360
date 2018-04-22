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
                            <?= form_open_multipart( 'admin/edit-pertanyaan-kuesioner/' .$id_pertanyaan) ?>

                            <div class="form-group">
                                <label for="id_kuesioner">Pilih Kuesioner</label>
                                <?php  
                                    $q = [];
                                    foreach ( $kuesioner as $row ) $q[$row->id_kuesioner] = $row->nama_kuesioner;
                                    echo form_dropdown( 'id_kuesioner', $q, $tanya->id_kuesioner, [ 'class' => 'form-control', 'required' => 'required' ] );
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <textarea name="pertanyaan" value="<?= $tanya->pertanyaan ?>" class="form-control" rows="5" required><?= $tanya->pertanyaan ?></textarea>
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