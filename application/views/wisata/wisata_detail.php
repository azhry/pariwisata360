	<!-- Slide1 -->
	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
				<?php for ( $i = 0; $i < count( $foto ); $i++ ): ?>
				<div class="item-slick1 item1-slick1" id="container-<?= $i ?>">
				</div>
				<?php endfor; ?>
			</div>

			<div class="wrap-slick1-dots"></div>
		</div>
	</section>

	<!-- Our Story -->
	<section class="bg2-pattern p-t-116 p-b-110 t-center p-l-15 p-r-15">
		<div class="container">
			<h3 class="tit5 t-center m-t-2">
				Deskripsi Wisata
			</h3>
			<p><?= $wisata->deskripsi ?></p>
		</div>
	</section>

	<section class="bg2-pattern p-t-116 p-b-110 t-center p-l-15 p-r-15">
		<div class="container">
			<h3 class="tit5 t-center m-t-2">
				Rute Wisata
			</h3>
			<div id="route-map" style="width: 100%; height: 450px;"></div>
		</div>
	</section>

	<!-- Review -->
	<section class="section-review p-t-115">
		<!-- - -->
		<div id="komentar-wisata" class="title-review t-center m-b-2">
			<span class="tit2 p-l-15 p-r-15">
				Komentar Pengunjung
			</span>
		</div>

		<?php if ( count( $komentar_wisata ) > 0 ): ?>
		<div class="wrap-slick3">
			<div class="slick3">
				<?php foreach ( $komentar_wisata as $komentar ): ?>
					<div class="item-slick3 item1-slick3">
						<div class="wrap-content-slide3 p-b-50 p-t-50">
							<div class="container">
								<div class="pic-review size14 bo4 wrap-cir-pic m-l-r-auto animated visible-false" data-appear="zoomIn">
									<img src="<?= base_url( 'assets/pato' ) ?>/images/avatar-01.jpg" alt="IGM-AVATAR">
								</div>

								<div class="content-review m-t-33 animated visible-false" data-appear="fadeInUp">
									<p class="t-center txt12 size15 m-l-r-auto">
										“ <?= $komentar->komentar ?> ”
									</p>

									<?php 
										$rating = $this->rating_wisata_m->get_row([ 'id_wisata' => $id_wisata, 'id_pengguna' => $this->session->userdata( 'id_pengguna' ) ]);
										if ( $rating ):
									?>
									<div class="star-review fs-18 color0 flex-c-m m-t-12">
										<i class="fa fa-star" aria-hidden="true"></i>
										<?php for ( $i = 0; $i < $rating->rating - 1; $i++ ): ?>
										<i class="fa fa-star p-l-1" aria-hidden="true"></i>
										<?php endfor; ?>
									</div>
								<?php endif; ?>

									<div class="more-review txt4 t-center animated visible-false m-t-32" data-appear="fadeInUp">
										<?= $komentar->nama ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="wrap-slick3-dots m-t-30"></div>
		</div>
		<?php else: ?>
		<h4 class="text-center" style="margin: 25px;">Belum ada komentar untuk saat ini</h4>
		<?php endif; ?>
	</section>

	<section class="bg2-pattern p-t-116 p-b-110 p-l-15 p-r-15">
		<style type="text/css">
			.star-rating {
			  line-height:32px;
			  font-size:1.25em;
			}

			.star-rating .fa-star{
				color: #ec1d25;
			}
		</style>
		<div class="container">
			<?= $this->session->flashdata( 'msg' ) ?>
			<div class="row">
				<div class="col-md-6">
					<?= form_open( 'wisata/detail/' . $id_wisata ) ?>
						<div class="form-group">
							<textarea class="form-control" name="komentar" placeholder="Beri komentar untuk wisata ini" required></textarea>
						</div>
						<input type="submit" name="submit_komentar" class="btn btn-danger" value="Submit">
					<?= form_close() ?>
				</div>
				<div class="col-md-6">
					<p id="rating-msg"></p>
					<div class="star-rating" id="display-rating">
						<span class="fa fa-star-o" data-rating="1"></span>
						<span class="fa fa-star-o" data-rating="2"></span>
						<span class="fa fa-star-o" data-rating="3"></span>
						<span class="fa fa-star-o" data-rating="4"></span>
						<span class="fa fa-star-o" data-rating="5"></span>
						<input type="hidden" name="rating" id="rating-value" class="rating-value" value="<?= isset( $rating ) ? $rating->rating : 0 ?>">
					</div>
					<button type="button" class="btn btn-danger btn-sm" id="beri_rating">Beri Rating</button>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $kuesioner ): ?>
	<section class="bg2-pattern p-t-116 p-b-110 t-center p-l-15 p-r-15">
		<div class="container">
			<h4 style="font-size: 30px;" class="tit5 t-center m-t-2">
				Kuesioner Wisata
			</h4>
			<center style="margin: 30px;">
				<a href="<?= base_url( 'wisata/kuesioner/' . $kuesioner->id_kuesioner )  ?>" class="btn btn-danger btn-lg">Isi Kuesioner Sekarang</a>
			</center>
		</div>

	</section>
	<?php endif; ?>

	<script type="text/javascript" src="<?= base_url( 'assets/photo-sphere-viewer/three.js' ) ?>"></script>
	<script type="text/javascript" src="<?= base_url( 'assets/photo-sphere-viewer/photo-sphere-viewer.min.js' ) ?>"></script>

	<script type="text/javascript">
		var map;
		function initMap() {

			let destPos = new google.maps.LatLng( <?= $wisata->latitude . ', ' . $wisata->longitude ?> );

			map = new google.maps.Map(document.getElementById( 'route-map' ), {
				center: destPos,
				zoom: 8
			});

			let destMarker = new google.maps.Marker({
				position: destPos,
				map: map
			});


			if ( navigator.geolocation ) {

				navigator.geolocation.getCurrentPosition(( position ) => {

					let currPos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};

					let currMarker = new google.maps.Marker({
						position: currPos,
						map: map
					});

					let bounds	= new google.maps.LatLngBounds();
					bounds.extend( destPos );
					bounds.extend( currPos );
					map.fitBounds( bounds );

					let requestDirection = {
						origin: currPos,
						destination: destPos,
						travelMode: google.maps.TravelMode.DRIVING
					};

					let directionRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true });
					let directionService = new google.maps.DirectionsService();
					directionService.route(requestDirection, ( response, status ) => {

						if ( status == google.maps.DirectionsStatus.OK ) {

							directionRenderer.setDirections( response );
							directionRenderer.setMap( map );


						}

					});

				}, () => {
					alert( 'Geolocation service failed' );
				});

			} else {
				alert( 'Your browser doesn\'t not support geolocation' );
			}

		}

		<?php $i = 0; foreach ( $foto as $row ): ?>
			let PSV<?= $i ?> = new PhotoSphereViewer({
				panorama: '<?= base_url( 'assets/img/wisata/' . $row ) ?>',
				container: document.getElementById( 'container-<?= $i++ ?>' ),
				time_anim: 3000,
				navbar: true,
				navbar_style: {
					backgroundColor: 'rgba(58, 67, 77, 0.7)'
				}
			});
		<?php endforeach; ?>

		$(document).ready(function() {
			var $star_rating = $('#display-rating .fa');

			var SetRatingStar = function() {
				return $star_rating.each(function() {
					if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
						return $(this).removeClass('fa-star-o').addClass('fa-star');
					} else {
						return $(this).removeClass('fa-star').addClass('fa-star-o');
					}
				});
			};

			$star_rating.on('click', function() {
				$star_rating.siblings('input.rating-value').val($(this).data('rating'));
				return SetRatingStar();
			});

			SetRatingStar();

			$( '#beri_rating' ).on('click', function() {
				
				var rating = $( '#rating-value' ).val();
				$.ajax({
					url: '<?= base_url( 'wisata/detail/' . $id_wisata ) ?>',
					type: 'POST',
					data: {
						beri_rating: true,
						rating: rating		
					},
					success: function( response ) {

						var json = $.parseJSON( response );
						$( '#rating-msg' ).text( json.msg );

					},
					error: function( err ) { console.log( err.responseText ); }
				});

			});

			<?php if ( strlen($this->session->flashdata( 'msg' )) > 0 ): ?>
				window.location = '<?= base_url( 'wisata/detail/' . $id_wisata . '#komentar-wisata' ) ?>';
			<?php endif; ?>
			
		});

	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $GOOGLE_MAPS_API_KEY ?>&callback=initMap"></script>

