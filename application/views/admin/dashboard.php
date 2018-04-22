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
                            <li class="active"><?= $title ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                	<div class="col-lg-4 col-sm-6 col-xs-12">
                		<a href="<?= base_url( 'admin/data-wisata' ) ?>">
                			<div class="white-box analytics-info">
	                            <h3 class="box-title">Data Wisata</h3>
	                            <ul class="list-inline two-part">
	                                <li>
	                                    <i style="font-size: 40px;" class="fa fa-globe"></i>
	                                </li>
	                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= count( $wisata ) ?></span></li>
	                            </ul>
	                        </div>
                		</a>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                		<a href="<?= base_url( 'admin/data-hak-akses' ) ?>">
                			<div class="white-box analytics-info">
	                            <h3 class="box-title">Data Hak Akses</h3>
	                            <ul class="list-inline two-part">
	                                <li>
	                                    <i style="font-size: 40px;" class="fa fa-users"></i>
	                                </li>
	                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= count( $hak_akses ) ?></span></li>
	                            </ul>
	                        </div>
                		</a>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                		<a href="<?= base_url( 'admin/data-pengguna' ) ?>">
                			<div class="white-box analytics-info">
	                            <h3 class="box-title">Data Pengguna</h3>
	                            <ul class="list-inline two-part">
	                                <li>
	                                    <i style="font-size: 40px;" class="fa fa-user"></i>
	                                </li>
	                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= count( $pengguna ) ?></span></li>
	                            </ul>
	                        </div>
                		</a>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                		<a href="<?= base_url( 'admin/data-kategori-wisata' ) ?>">
                			<div class="white-box analytics-info">
	                            <h3 class="box-title">Data Kategori Wisata</h3>
	                            <ul class="list-inline two-part">
	                                <li>
	                                    <i style="font-size: 40px;" class="fa fa-list"></i>
	                                </li>
	                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= count( $kategori_wisata ) ?></span></li>
	                            </ul>
	                        </div>
                		</a>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                		<a href="<?= base_url( 'admin/data-komentar-wisata' ) ?>">
                			<div class="white-box analytics-info">
	                            <h3 class="box-title">Data Komentar Wisata</h3>
	                            <ul class="list-inline two-part">
	                                <li>
	                                    <i style="font-size: 40px;" class="fa fa-comment"></i>
	                                </li>
	                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= count( $komentar_wisata ) ?></span></li>
	                            </ul>
	                        </div>
                		</a>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                		<a href="<?= base_url( 'admin/data-rating-wisata' ) ?>">
                			<div class="white-box analytics-info">
	                            <h3 class="box-title">Data Rating Wisata</h3>
	                            <ul class="list-inline two-part">
	                                <li>
	                                    <i style="font-size: 40px;" class="fa fa-star"></i>
	                                </li>
	                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= count( $rating_wisata ) ?></span></li>
	                            </ul>
	                        </div>
                		</a>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                		<a href="<?= base_url( 'admin/data-kuesioner' ) ?>">
                			<div class="white-box analytics-info">
	                            <h3 class="box-title">Data Kuesioner</h3>
	                            <ul class="list-inline two-part">
	                                <li>
	                                    <i style="font-size: 40px;" class="fa fa-list-ol"></i>
	                                </li>
	                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= count( $kuesioner_wisata ) ?></span></li>
	                            </ul>
	                        </div>
                		</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Ample Admin brought to you by wrappixel.com </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->