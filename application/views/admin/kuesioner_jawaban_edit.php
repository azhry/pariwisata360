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
                            <?= form_open_multipart( 'admin/edit-jawaban-kuesioner/' .$id_jawaban) ?>

                            <div class="form-group">
                                <label for="id_kuesioner">Pilih Kuesioner</label>
                                <?php  
                                    $qa = [];
                                    foreach ( $kuesioner as $row ) $qa[$row->id_kuesioner] = $row->nama_kuesioner;
                                    echo form_dropdown( 'id_pertanyaan', $qa, $jawab->id_pertanyaan, [ 'class' => 'form-control', 'required' => 'required' ] );
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="id_pertanyaan">Pilih Pertanyaan</label>
                                <?php  
                                    $qa = [];
                                    foreach ( $pertanyaan as $row ) $qa[$row->id_pertanyaan] = $row->pertanyaan;
                                    echo form_dropdown( 'id_pertanyaan', $qa, $jawab->id_pertanyaan, [ 'class' => 'form-control', 'required' => 'required' ] );
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="jawaban">Jawaban</label>
                                <textarea name="jawaban" value="<?= $jawab->jawaban ?>" class="form-control" rows="5" required><?= $jawab->jawaban ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="nilai">nilai</label>
                                <input type="number" value="<?= $jawab->nilai ?>" step="any" name="nilai" class="form-control" required>
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