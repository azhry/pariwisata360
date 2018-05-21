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
                            <?= form_open_multipart( 'admin_wisata/tambah-pertanyaan-kuesioner/' . $id_kuesioner ) ?>

                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <textarea name="pertanyaan" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="id_kategori">Kategori</label>
                                <select class="form-control" name="id_kategori" required>
                                    <?php foreach ( $kategori as $row ): ?>
                                        <option value="<?= $row->id_kategori ?>"><?= $row->kategori ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div id="jawaban-container">
                                <label for="jawaban">Jawaban <button type="button" id="tambah-pertanyaan-button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button></label>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <textarea class="form-control" name="jawaban[]" placeholder="Jawaban 1" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="number" min="1" max="5" class="form-control" name="nilai[]" placeholder="Nilai jawaban 1" required>
                                        </div>  
                                    </div>
                                </div>
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

        <script type="text/javascript">
            $( document ).ready(function() {

                var idx = 1;
                $( '#tambah-pertanyaan-button' ).on('click', function() {

                    $( '#jawaban-container' ).append('<div class="row">' +
                        '<div class="col-md-9">' +
                            '<div class="form-group">' +
                                '<textarea class="form-control" name="jawaban[]" placeholder="Jawaban ' + ++idx + '" required></textarea>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                            '<div class="form-group">' +
                                '<input type="number" min="1" max="5" class="form-control" name="nilai[]" placeholder="Nilai jawaban ' + idx + '" required>' +
                            '</div>' +
                        '</div>' +
                    '</div>');

                });

            });
        </script>