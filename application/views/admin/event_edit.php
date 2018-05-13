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
                            <li><a href="<?= base_url( 'admin/index' ) ?>">Dashboard</a></li>
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
                            <?= form_open_multipart( 'admin/edit-event/'. $id_event ) ?>

                            <div class="form-group">
                                <label for="nama_wisata">Nama Event</label>
                                <input type="text" value="<?= $event->nama_event ?>" name="nama_event" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" value="<?= $event->deskripsi ?>" name="deskripsi" class="form-control" required>
                            </div>

                            <?php $foto = json_decode( $event->foto ); ?>
                            <input type="hidden" name="num_img" value="<?= count( $foto ) ?>" id="num-img">
                            <button type="button" id="tambah-foto-btn" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Foto</button>
                            <div id="foto-container">
                                <?php $i = 0; foreach ( $foto as $f ): ?>
                                <div class="form-group">
                                    <label for="foto">Foto <?= ++$i ?> <button onclick="hapus_foto( '<?= $f ?>', this );" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></label><br>
                                    <img src="<?= base_url( 'assets/img/wisata/' . $f ) ?>" width="150" height="150">
                                    <input type="file" name="berkas<?= $i ?>" accept="image/*" class="form-control">
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <div id="deleted-photos"></div>

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

        <script type="text/javascript">

            $( document ).ready(function() {

                var idx = <?= count( $foto ) ?>;

                $( '#tambah-foto-btn' ).on('click', function() {

                    $( '#foto-container' ).append('<div class="form-group">' +
                        '<label for="foto">Foto ' + (++idx) + '</label>' +
                        '<input type="file" name="berkas' + idx + '" accept="image/*" class="form-control" required>' +
                    '</div>');

                    $( '#num-img' ).val( idx );

                });

            });

            function hapus_foto( nama_foto, el ) {

                $( el ).parent().parent().remove();
                $( '#deleted-photos' ).append( '<input type="hidden" name="deleted_photos[]" value="' + nama_foto + '" />' );

            }
        </script>