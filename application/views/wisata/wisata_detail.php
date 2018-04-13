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
		<div class="title-review t-center m-b-2">
			<span class="tit2 p-l-15 p-r-15">
				Customers Say
			</span>

			<h3 class="tit8 t-center p-l-20 p-r-15 p-t-3">
				Review
			</h3>
		</div>

		<!-- - -->
		<div class="wrap-slick3">
			<div class="slick3">
				<div class="item-slick3 item1-slick3">
					<div class="wrap-content-slide3 p-b-50 p-t-50">
						<div class="container">
							<div class="pic-review size14 bo4 wrap-cir-pic m-l-r-auto animated visible-false" data-appear="zoomIn">
								<img src="<?= base_url( 'assets/pato' ) ?>/images/avatar-01.jpg" alt="IGM-AVATAR">
							</div>

							<div class="content-review m-t-33 animated visible-false" data-appear="fadeInUp">
								<p class="t-center txt12 size15 m-l-r-auto">
									“ We are lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tellus sem, mattis in pre-tium nec, fermentum viverra dui ”
								</p>

								<div class="star-review fs-18 color0 flex-c-m m-t-12">
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
								</div>

								<div class="more-review txt4 t-center animated visible-false m-t-32" data-appear="fadeInUp">
									Marie Simmons ˗ New York
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick3 item2-slick3">
					<div class="wrap-content-slide3 p-b-50 p-t-50">
						<div class="container">
							<div class="pic-review size14 bo4 wrap-cir-pic m-l-r-auto animated visible-false" data-appear="zoomIn">
								<img src="<?= base_url( 'assets/pato' ) ?>/images/avatar-04.jpg" alt="IGM-AVATAR">
							</div>

							<div class="content-review m-t-33 animated visible-false" data-appear="fadeInUp">
								<p class="t-center txt12 size15 m-l-r-auto">
									“ We are lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tellus sem, mattis in pre-tium nec, fermentum viverra dui ”
								</p>

								<div class="star-review fs-18 color0 flex-c-m m-t-12">
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
								</div>

								<div class="more-review txt4 t-center animated visible-false m-t-32" data-appear="fadeInUp">
									Marie Simmons ˗ New York
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick3 item3-slick3">
					<div class="wrap-content-slide3 p-b-50 p-t-50">
						<div class="container">
							<div class="pic-review size14 bo4 wrap-cir-pic m-l-r-auto animated visible-false" data-appear="zoomIn">
								<img src="<?= base_url( 'assets/pato' ) ?>/images/avatar-05.jpg" alt="IGM-AVATAR">
							</div>

							<div class="content-review m-t-33 animated visible-false" data-appear="fadeInUp">
								<p class="t-center txt12 size15 m-l-r-auto">
									“ We are lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tellus sem, mattis in pre-tium nec, fermentum viverra dui ”
								</p>

								<div class="star-review fs-18 color0 flex-c-m m-t-12">
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
									<i class="fa fa-star p-l-1" aria-hidden="true"></i>
								</div>

								<div class="more-review txt4 t-center animated visible-false m-t-32" data-appear="fadeInUp">
									Marie Simmons ˗ New York
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="wrap-slick3-dots m-t-30"></div>
		</div>
	</section>

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
	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $GOOGLE_MAPS_API_KEY ?>&callback=initMap"></script>

