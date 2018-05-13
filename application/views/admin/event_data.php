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
                            <a href="<?= base_url( 'admin/tambah-event' ) ?>" class="btn btn-success"><i class="fa fa-plus"></i></a>
                            <?= $this->session->flashdata( 'msg' ) ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>                                        
                                        <th>Nama Event</th>
                                        <th>Deskripsi</th>
                                        <th>Foto</th>
                                        <th>Create at</th>
                                        <th>Update at</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach ( $event as $row ): ?>
                                        <tr>
                                            <td><?= ++$i ?></td>
                                            <td><?= $row->nama_event ?></td>
                                            <td><?= $row->deskripsi ?></td>
                                            <td><?= $row->foto ?></td>
                                            <td><?= $row->created_at ?></td>
                                            <td><?= $row->updated_at ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= base_url( 'admin/edit-event/' . $row->id_event ) ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="<?= base_url( 'admin/data-event/' . $row->id_event . '/delete' ) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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