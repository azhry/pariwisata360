		<!-- Slide1 -->
	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
				<?php for ( $i = 0; $i < count( $foto ); $i++ ): ?>
				<div class="item-slick1 item<?= $i + 1 ?>-slick1" style="background-image: url(<?= base_url( 'assets/img/wisata/' . $foto[$i] ) ?>);">
				</div>
				<?php endfor; ?>
			</div>

			<div class="wrap-slick1-dots"></div>
		</div>
	</section>

	<!-- Our Story -->
	<section class="bg2-pattern p-t-116 p-b-110 p-l-15 p-r-15">
		<div class="container">
			<h3 class="tit5 t-center m-t-2">
				Deskripsi Event
			</h3>
			<p><?= $event->deskripsi ?></p>
		</div>
	</section>
