		<!-- Slide1 -->
	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1 item1-slick1" style="background-image: url(<?= base_url( 'assets/pato' ) ?>/images/slide1-01.jpg);">
					<div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
						<span class="caption1-slide1 txt1 t-center animated visible-false m-b-15" data-appear="fadeInDown">
							Welcome to
						</span>

						<h2 class="caption2-slide1 tit1 t-center animated visible-false m-b-37" data-appear="fadeInUp">
							Pato Place
						</h2>

						<div class="wrap-btn-slide1 animated visible-false" data-appear="zoomIn">
							<!-- Button1 -->
							<a href="<?= base_url( 'assets/pato' ) ?>/menu.html" class="btn1 flex-c-m size1 txt3 trans-0-4">
								Look Menu
							</a>
						</div>
					</div>
				</div>

				<div class="item-slick1 item2-slick1" style="background-image: url(<?= base_url( 'assets/pato' ) ?>/images/master-slides-02.jpg);">
					<div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
						<span class="caption1-slide1 txt1 t-center animated visible-false m-b-15" data-appear="rollIn">
							Welcome to
						</span>

						<h2 class="caption2-slide1 tit1 t-center animated visible-false m-b-37" data-appear="lightSpeedIn">
							Pato Place
						</h2>

						<div class="wrap-btn-slide1 animated visible-false" data-appear="slideInUp">
							<!-- Button1 -->
							<a href="<?= base_url( 'assets/pato' ) ?>/menu.html" class="btn1 flex-c-m size1 txt3 trans-0-4">
								Look Menu
							</a>
						</div>
					</div>
				</div>

				<div class="item-slick1 item3-slick1" style="background-image: url(<?= base_url( 'assets/pato' ) ?>/images/master-slides-01.jpg);">
					<div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
						<span class="caption1-slide1 txt1 t-center animated visible-false m-b-15" data-appear="rotateInDownLeft">
							Welcome to
						</span>

						<h2 class="caption2-slide1 tit1 t-center animated visible-false m-b-37" data-appear="rotateInUpRight">
							Pato Place
						</h2>

						<div class="wrap-btn-slide1 animated visible-false" data-appear="rotateIn">
							<!-- Button1 -->
							<a href="<?= base_url( 'assets/pato' ) ?>/menu.html" class="btn1 flex-c-m size1 txt3 trans-0-4">
								Look Menu
							</a>
						</div>
					</div>
				</div>

			</div>

			<div class="wrap-slick1-dots"></div>
		</div>
	</section>

	<!-- Our Story -->
	<section class="bg2-pattern p-t-116 p-b-110 t-center p-l-15 p-r-15">
		<div class="container">
			<div class="row">
				<?php foreach ( $wisata as $row ): ?>
				<?php $foto = json_decode( $row->foto ); ?>
				<div class="col-md-4 p-t-30">
					<div class="blo1">
						<div class="wrap-pic-blo1 bo-rad-10 hov-img-zoom">
							<a href="<?= base_url( 'wisata/detail/' . $row->id_wisata ) ?>"><img src="<?= count( $foto ) > 0 ? base_url( 'assets/img/wisata/' . $foto[0] ) : base_url( 'assets/pato/images/intro-01.jpg' ) ?>" alt="IMG-THUMBNAIL"></a>
						</div>

						<div class="wrap-text-blo1 p-t-35">
							<a href="<?= base_url( 'wisata/detail/' . $row->id_wisata ) ?>"><h4 class="txt5 color0-hov trans-0-4 m-b-13">
								<?= $row->nama_wisata ?>
							</h4></a>

							<p class="m-b-20">
								<?php 
									$len = strlen( $row->deskripsi );
									if ( $len > 100 ) echo substr( $row->deskripsi , 0, 100 ) . '...';
									else echo $row->deskripsi;
								?>
							</p>

							<a href="<?= base_url( 'wisata/detail/' . $row->id_wisata ) ?>" class="txt4">
								Lihat
								<i class="fa fa-long-arrow-right m-l-10" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

