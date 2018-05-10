	<section class="bg2-pattern p-t-116 p-b-110 t-center p-l-15 p-r-15">
		<div class="container">
			<div class="row">
				<?php foreach ( $wisata as $row ): ?>
				<div class="col-md-4 p-t-30">
					<div class="blo1">
						<div class="wrap-pic-blo1 bo-rad-10 hov-img-zoom">
							<a href="<?= base_url( 'wisata/detail/' . $row->id_wisata ) ?>"><img src="<?= !empty( $row->thumbnail ) ? base_url( 'assets/img/wisata/' . $row->thumbnail ) : base_url( 'assets/pato/images/intro-01.jpg' ) ?>" alt="IMG-THUMBNAIL"></a>
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

