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
                            <li><a href="<?= base_url( 'admin/data-kuesioner' ) ?>"><?= $kuesioner->nama_kuesioner ?></a></li>
                            <li class="active"><?= $title ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title"><?= $kuesioner->nama_kuesioner ?></h3> 
                            <a href="<?= base_url( 'admin/tambah-pertanyaan-kuesioner/' . $id_kuesioner ) ?>" class="btn btn-success"><i class="fa fa-plus"></i></a>
                            <?= $this->session->flashdata( 'msg' ) ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pertanyaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach ( $pertanyaan as $row): ?>
                                        <tr>
                                            <td><?= ++$i ?></td>
                                            <td><?= $row->pertanyaan ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= base_url( 'admin/edit-pertanyaan-kuesioner/' . $row->id_pertanyaan ) ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="<?= base_url( 'admin/data-pertanyaan-kuesioner/' . $row->id_pertanyaan . '/delete' ) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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