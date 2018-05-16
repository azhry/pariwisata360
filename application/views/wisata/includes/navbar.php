		<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="wrap-menu-header gradient1 trans-0-4">
			<div class="container h-full">
				<div class="wrap_header trans-0-3">
					<!-- Logo -->
					<div class="logo">
						<a href="<?= base_url( 'wisata' ) ?>">
							<img src="<?= base_url( 'assets/pato' ) ?>/images/icons/logo.png" alt="IMG-LOGO" data-logofixed="<?= base_url( 'assets/pato' ) ?>/images/icons/logo2.png">
						</a>
					</div>

					<!-- Menu -->
					<div class="wrap_menu p-l-45 p-l-0-xl">
						<nav class="menu">
							<ul class="main_menu">
								<li>
									<a href="<?= base_url( 'wisata' ) ?>">Beranda</a>
								</li>

								<li>
									<a href="<?= base_url( 'wisata/kategori' ) ?>">Wisata</a>
								</li>

								<li>
									<a href="<?= base_url( 'wisata/list-event' ) ?>">Event</a>
								</li>								

								<li>
									<a href="<?= base_url( 'wisata/galeri' ) ?>">Galeri</a>
								</li>

								<li>
									<a href="<?= base_url( 'wisata/kontak' ) ?>">Kontak</a>
								</li>
							</ul>
						</nav>
					</div>

					<!-- Social -->
					<div class="social flex-w flex-l-m p-r-20">
						<?php if ( $this->session->userdata( 'id_pengguna' ) && $this->session->userdata( 'hak_akses' ) ): ?>
						<a href="<?= base_url( 'logout' ) ?>">LOGOUT</a>
						<?php else: ?>
						<a href="<?= base_url( 'auth' ) ?>">LOGIN</a>
						<?php endif; ?>
						<!-- <button class="btn-show-sidebar m-l-33 trans-0-4"></button> -->
					</div>
				</div>
			</div>
		</div>
	</header>