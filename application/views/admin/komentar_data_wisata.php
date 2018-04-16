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
                            <li><a href="<?= base_url( 'admin/data-wisata' ) ?>">Dashboard</a></li>
                            <li class="active"><?= $title ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title"><?= $title ?></h3> 
                            <a href="<?= base_url( 'admin/tambah-komentar-wisata' ) ?>" class="btn btn-success"><i class="fa fa-plus"></i></a>
                            <?= $this->session->flashdata( 'msg' ) ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID Pengguna</th>
                                        <th>ID Wisata</th>
                                        <th>Komentar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach ( $komentar_wisata as $row): ?>
                                        <tr>
                                            <td><?= ++$i ?></td>
                                            <td><?= $row->id_pengguna ?></td>
                                            <td><?= $row->id_wisata ?></td>
                                            <td><?= $row->komentar ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= base_url( 'admin/edit-kategori-wisata/' . $row->id_komentar ) ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="<?= base_url( 'admin/data-kategori-wisata/' . $row->id_komentar . '/delete' ) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

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