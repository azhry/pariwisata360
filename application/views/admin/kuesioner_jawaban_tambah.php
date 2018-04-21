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
                            <?= form_open_multipart( 'admin/tambah-jawaban-kuesioner' ) ?>

                            <div class="form-group">
                                <label for="id_kuesioner">Kuesioner</label>
                                <select class="form-control" name="id_kuesioner" required>
                                    <option>Pilih Kuesioner</option>
                                    <?php foreach ( $kuesioner as $row ): ?>
                                    <option value="<?= $row->id_kuesioner ?>"><?= $row->nama_kuesioner ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_pertanyaan">Pertanyaan</label>
                                <select class="form-control" name="id_pertanyaan" required>
                                    <option>Pilih Pertanyaan</option>
                                    <?php foreach ( $pertanyaan as $row ): ?>
                                    <option value="<?= $row->id_pertanyaan ?>"><?= $row->pertanyaan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jawaban">Jawaban</label>
                                <textarea name="jawaban" class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="nilai">nilai</label>
                                <input type="number" step="any" name="nilai" class="form-control" required>
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