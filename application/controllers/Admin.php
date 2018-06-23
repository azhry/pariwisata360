<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin extends MY_Controller {

	public function __construct() {

		parent::__construct();
		$this->data['id_pengguna']	= $this->session->userdata( 'id_pengguna' );
		if ( !isset( $this->data['id_pengguna'] ) ) {

			$this->session->sess_destroy();
			$this->flashmsg( 'Anda tidak memiliki hak akses untuk halaman tersebut', 'danger' );
			redirect( 'auth' );

		}

		$this->data['hak_akses']	= $this->session->userdata( 'hak_akses' );
		if ($this->data['hak_akses'] != 'Admin')
		{
			redirect('auth');
		}
	}

	public function index() {

		$this->load->model( 'wisata_m' );
		$this->load->model( 'pengguna_m' );
		$this->load->model( 'hak_akses_m' );
		$this->load->model( 'kategori_wisata_m' );
		$this->load->model( 'komentar_wisata_m' );
		$this->load->model( 'rating_wisata_m' );
		$this->load->model( 'kuesioner_m' );
		$this->data['wisata']			= $this->wisata_m->get();
		$this->data['hak_akses']		= $this->hak_akses_m->get();
		$this->data['pengguna']			= $this->pengguna_m->get();
		$this->data['kategori_wisata']	= $this->kategori_wisata_m->get();
		$this->data['komentar_wisata']	= $this->komentar_wisata_m->get();
		$this->data['rating_wisata']	= $this->rating_wisata_m->get();
		$this->data['kuesioner_wisata']	= $this->kuesioner_m->get();
		$this->data['title']			= 'Dashboard';
		$this->data['content']			= 'admin/dashboard';
		$this->template( $this->data, 'admin' );

	}

	public function data_pengguna() {

		$this->load->model( 'pengguna_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_pengguna']	= $this->uri->segment( 3 );
			$this->pengguna_m->delete( $this->data['id_pengguna'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-pengguna' );
			exit;

		}

		$this->data['pengguna']	= $this->pengguna_m->get();
		$this->data['title']	= 'Data Pengguna';
		$this->data['content']	= 'admin/pengguna_data';
		$this->template( $this->data, 'admin' );

	}

	public function tambah_pengguna() {

		$this->load->model( 'hak_akses_m' );
		$this->data['hak_akses']	= $this->hak_akses_m->get();

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'pengguna_m' );
			$this->data['pengguna'] = [
				'id_pengguna'	=> $this->__generate_random_id(),
				'id_hak_akses'	=> $this->POST( 'id_hak_akses' ),
				'email'			=> $this->POST( 'email' ),
				'password'		=> md5( $this->POST( 'password' ) ),
				'nama'			=> $this->POST( 'nama' ),
				'tempat_lahir'	=> $this->POST( 'tempat_lahir' ),
				'tanggal_lahir'	=> $this->POST( 'tanggal_lahir' )
			];
			$this->pengguna_m->insert( $this->data['pengguna'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-pengguna' );
			exit;

		}

		$this->data['title']		= 'Tambah Pengguna';
		$this->data['content']		= 'admin/pengguna_tambah';
		$this->template( $this->data, 'admin' );

	}

	public function edit_pengguna() {

		$this->data['id_pengguna']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_pengguna'] ) );

		$this->load->model( 'hak_akses_m' );
		$this->load->model( 'pengguna_m' );

		if ( $this->POST( 'edit' ) ) {

			$this->data['pengguna']	= [
				'id_hak_akses'	=> $this->POST( 'id_hak_akses' ),
				'email'			=> $this->POST( 'email' ),
				'nama'			=> $this->POST( 'nama' ),
				'tempat_lahir'	=> $this->POST( 'tempat_lahir' ),
				'tanggal_lahir'	=> $this->POST( 'tanggal_lahir' ),
				'updated_at'	=> date( 'Y-m-d H:i:s' )
			];
			$password = $this->POST( 'password' );
			if ( !empty( $password ) ) $this->data['pengguna']['password'] = md5( $password );
			$this->pengguna_m->update( $this->data['id_pengguna'], $this->data['pengguna'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-pengguna/' . $this->data['id_pengguna'] );
			exit;

		}

		$this->data['pengguna']		= $this->pengguna_m->get_row([ 'id_pengguna' => $this->data['id_pengguna'] ]);
		$this->check_allowance( !isset( $this->data['pengguna'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );

		$this->data['hak_akses']	= $this->hak_akses_m->get();
		$this->data['title']		= 'Edit Pengguna';
		$this->data['content']		= 'admin/pengguna_edit';
		$this->template( $this->data, 'admin' );

	}

	public function data_wisata() {

		// abdi
		// buat file baru wisata_data.php di ./views/admin

		$this->load->model( 'wisata_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_wisata']	= $this->uri->segment( 3 );
			$this->data['wisata']		= $this->wisata_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);

			if ( isset( $this->data['id_wisata'] ) ) {

				$this->wisata_m->delete( $this->data['id_wisata'] );
				$imgs = json_decode( $this->data['wisata']->foto );
				foreach ( $imgs as $img ) {
					@unlink( realpath( FCPATH . '/assets/img/wisata/' . $img ) );
				}
				$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			
			} else {

				$this->flashmsg( '<i class="fa fa-times"></i> Data tidak ditemukan', 'danger' );

			}

			redirect( 'admin/data-wisata' );
			exit;

		}

		$this->data['wisata']	= $this->wisata_m->get();
		$this->data['title']	= 'Data Wisata';
		$this->data['content']	= 'admin/wisata_data';
		$this->template( $this->data, 'admin' );

	}

	public function tambah_wisata() {

		// abdi
		// buat file baru wisata_tambah.php di ./views/admin

		$this->config->load( 'app' );
		$this->data['GOOGLE_MAPS_API_KEY'] = $this->config->item( 'GOOGLE_MAPS_API_KEY' );

		$this->load->model( 'hak_akses_m' );
		$this->data['hak_akses']	= $this->hak_akses_m->get();
		$this->load->model( 'kategori_wisata_m' );
		$this->load->model( 'pengguna_m' );
		$this->data['admin_wisata'] = $this->pengguna_m->get([ 'id_hak_akses' => 4 ]);

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'wisata_m' );
			$id_wisata 	= $this->__generate_random_id();
			$num_img 	= $this->POST( 'num_img' );
			$foto		= [];
			for ( $i = 0; $i < $num_img; $i++ ) {
				
				$img_name = $id_wisata . '_' . pathinfo( $_FILES[ 'berkas' . ($i + 1) ]['name'], PATHINFO_FILENAME );
				$this->upload( $img_name, '/assets/img/wisata', 'berkas' . ($i + 1) );
				$foto []= $img_name . '.jpg';

			} 

			$this->data['wisata'] = [
				'id_wisata'		=> $id_wisata,
				'nama_wisata'	=> $this->POST( 'nama_wisata' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'foto'			=> json_encode( $foto ),
				'latitude'		=> $this->POST( 'latitude' ),
				'longitude'		=> $this->POST( 'longitude' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
				'id_admin'		=> $this->POST( 'id_admin' )
			];
			$this->wisata_m->insert( $this->data['wisata'] );
			
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-wisata' );
			exit;

		}

		$this->data['kategori']		= $this->kategori_wisata_m->get();
		$this->data['title']		= 'Tambah Wisata';
		$this->data['content']		= 'admin/wisata_tambah';
		$this->template( $this->data, 'admin' );

	}

	public function edit_wisata() {

		// abdi
		// buat file baru wisata_edit.php di ./views/admin

		$this->config->load( 'app' );
		$this->data['GOOGLE_MAPS_API_KEY'] = $this->config->item( 'GOOGLE_MAPS_API_KEY' );

		$this->data['id_wisata']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_wisata'] ) );

		$this->load->model( 'hak_akses_m' );
		$this->load->model( 'wisata_m' );
		$this->load->model( 'kategori_wisata_m' );

		$this->data['wisata']		= $this->wisata_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);
		$this->check_allowance( !isset( $this->data['wisata'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );

		$this->data['foto']			= json_decode($this->data['wisata']->foto);

		if ($this->POST('edit')) 
		{	
			for ($i = 0; $i < $this->POST('num_img'); $i++)
			{
				if (isset($_FILES['berkas' . ($i + 1)]))
				{
					if (!empty($_FILES['berkas' . ($i + 1)]['name']))
					{
						@unlink(realpath(FCPATH . '/assets/img/wisata/' . $this->data['foto'][$i]));
						array_splice($this->data['foto'], $i, 1);
						$img_name = $this->data['id_wisata'] . '_' . pathinfo( $_FILES[ 'berkas' . ($i + 1) ]['name'], PATHINFO_FILENAME );
						$this->upload( $img_name, '/assets/img/wisata', 'berkas' . ($i + 1) );
						$this->data['foto'] []= $img_name . '.jpg';
					}
				}
				else
				{
					if ($i < count($this->data['foto']))
					{
						@unlink(realpath(FCPATH . '/assets/img/wisata/' . $this->data['foto'][$i]));
						array_splice($this->data['foto'], $i, 1);
					}
				}
			}

			$this->data['wisata']	= [
				'nama_wisata'	=> $this->POST( 'nama_wisata' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'latitude'		=> $this->POST( 'latitude' ),
				'longitude'		=> $this->POST( 'longitude' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
				'id_admin'		=> $this->POST('id_admin'),
				'foto'			=> json_encode($this->data['foto']),
				'updated_at'	=> date( 'Y-m-d H:i:s' )
			];
			$this->wisata_m->update( $this->data['id_wisata'], $this->data['wisata'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-wisata/' . $this->data['id_wisata'] );
			exit;
		}

		$this->load->model('pengguna_m');
		$this->data['admin_wisata'] 	= $this->pengguna_m->get(['id_hak_akses' => 4]);

		$this->data['data_kategori']	= $this->kategori_wisata_m->get();
		$this->data['kategori']			= [];
		foreach ( $this->data['data_kategori'] as $kategori ) $this->data['kategori'][$kategori->id_kategori] = $kategori->nama_kategori;

		$this->data['hak_akses']		= $this->hak_akses_m->get();
		$this->data['title']			= 'Edit Wisata';
		$this->data['content']			= 'admin/wisata_edit';
		$this->template( $this->data, 'admin' );

	}


	public function data_hak_akses() {

		// irsyad
		// buat file baru hak_akses_data.php di ./views/admin
		$this->load->model( 'Hak_akses_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_hak_akses']	= $this->uri->segment( 3 );
			$this->Hak_akses_m->delete( $this->data['id_hak_akses'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-hak-akses' );
			exit;

		}

		$this->data['akses']	= $this->Hak_akses_m->get();
		$this->data['title']	= 'Data Hak Akses';
		$this->data['content']	= 'admin/hak_akses_data';
		$this->template( $this->data, 'admin' );

	}

	public function tambah_hak_akses() {

		// irsyad
		// buat file baru hak_akses_tambah.php di ./views/admin

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'Hak_akses_m' );
			$this->data['akses'] = [
				'label' => $this->POST('label'),
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			];
			$this->Hak_akses_m->insert( $this->data['akses'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-hak-akses' );
			exit;

		}

		$this->data['title']		= 'Tambah Hak Akses';
		$this->data['content']		= 'admin/hak_akses_tambah';
		$this->template( $this->data, 'admin' );
	}

	public function edit_hak_akses() {

		// irsyad
		// buat file baru hak_akses_edit.php di ./views/admin
		$this->data['id_hak_akses']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_hak_akses'] ) );

		$this->load->model( 'hak_akses_m' );

		if ( $this->POST( 'edit' ) ) {

			$this->data['akses']	= [
				'label' 		=> $this->POST( 'label' ),
				'updated_at'	=> date( 'Y-m-d H:i:s' )
			];
			
			$this->hak_akses_m->update( $this->data['id_hak_akses'], $this->data['akses'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-hak-akses/' . $this->data['id_hak_akses'] );
			exit;

		}

		$this->data['akses']		= $this->hak_akses_m->get_row([ 'id_hak_akses' => $this->data['id_hak_akses'] ]);
		$this->check_allowance( !isset( $this->data['akses'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );

		$this->data['title']		= 'Edit Hak Akses';
		$this->data['content']		= 'admin/hak_akses_edit';
		$this->template( $this->data, 'admin' );

	}

	public function data_kategori_wisata() {
		// abdi
		$this->load->model( 'kategori_wisata_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_kategori']			= $this->uri->segment( 3 );
			$this->data['kategori_wisata']		= $this->kategori_wisata_m->get_row([ 'id_kategori' => $this->data['id_kategori'] ]);
			if ( isset( $this->data['id_kategori'] ) ) {

				$this->kategori_wisata_m->delete( $this->data['id_kategori'] );
				$img_name = $this->data['kategori_wisata']->foto;
				@unlink( realpath( FCPATH . '/assets/img/kategori_wisata/' . $img_name ) );
				$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			
			} else {

				$this->flashmsg( '<i class="fa fa-times"></i> Data tidak ditemukan', 'danger' );

			}


		}

		$this->data['kategori_wisata']	= $this->kategori_wisata_m->get();
		$this->data['title']	= 'Data Kategori';
		$this->data['content']	= 'admin/kategori_data';
		$this->template( $this->data, 'admin' );
		
	}

	public function tambah_kategori_wisata() {
		// abdi
		if ( $this->POST( 'submit' ) ) {
			$this->load->model( 'kategori_wisata_m' );
			$id_kategori = $this->__generate_random_id();
			
			$img_name = $id_kategori . '_' . pathinfo( $_FILES['berkas']['name'], PATHINFO_FILENAME );
			$this->upload( $img_name, '/assets/img/kategori_wisata/', 'berkas' );
			$img_name .= '.jpg';
			$this->data['kategori_wisata'] = [
				'id_kategori'	=> $id_kategori,
				'nama_kategori'	=> $this->POST( 'nama_kategori' ),
				'foto'			=> $img_name,
				'deskripsi'		=> $this->POST( 'deskripsi' )
			];

			$this->kategori_wisata_m->insert( $this->data['kategori_wisata'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-kategori-wisata' );
			exit;

		}

		
		$this->data['title']		= 'Tambah Kategori';
		$this->data['content']		= 'admin/kategori_tambah';
		$this->template( $this->data, 'admin' );

	}

	public function edit_kategori_wisata() {
		// abdi
		$this->data['id_kategori']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_kategori'] ) );

		$this->load->model( 'kategori_wisata_m' );
		$this->data['kategori']		= $this->kategori_wisata_m->get_row([ 'id_kategori' => $this->data['id_kategori'] ]);
		$this->check_allowance( !isset( $this->data['kategori'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		

		if ( $this->POST( 'edit' ) ) {

			$this->data['edit_kategori']	= [
				'nama_kategori' => $this->POST('nama_kategori'),
				'deskripsi' => $this->POST('deskripsi'),
				'updated_at' => date("Y-m-d H:i:s")
			];

			if ( !empty( $_FILES['berkas']['name'] ) ) {

				@unlink( FCPATH . '/assets/img/kategori_wisata/' . $this->data['kategori']->foto );
				$img_name = $this->data['id_kategori'] . '_' . pathinfo( $_FILES['berkas']['name'], PATHINFO_FILENAME );
				$this->upload( $img_name, '/assets/img/kategori_wisata', 'berkas' );
				$this->data['edit_kategori']['foto'] = $img_name . '.jpg';

			}

			$this->kategori_wisata_m->update( $this->data['id_kategori'], $this->data['edit_kategori'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/data-kategori-wisata/' . $this->data['id_kategori'] );
			exit;

		}

		$this->data['title']		= 'Edit Kategori Wisata';
		$this->data['content']		= 'admin/kategori_edit';
		$this->template( $this->data, 'admin' );
	}



	public function data_komentar_wisata() {
		// abdi

		$this->load->model( 'komentar_wisata_m' );
		$this->load->model('pengguna_m');
		$this->load->model('wisata_m');
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_komentar']	= $this->uri->segment( 3 );
			$this->komentar_wisata_m->delete( $this->data['id_komentar'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-komentar-wisata' );
			exit;

		}

		$this->data['pengguna'] = $this->pengguna_m->get();
		$this->data['wisata'] = $this->wisata_m->get();
		$this->data['komentar_wisata']	= $this->komentar_wisata_m->get();
		$this->data['title']	= 'Data Komentar Wisata';
		$this->data['content']	= 'admin/komentar_data_wisata';
		$this->template( $this->data, 'admin' );

	}

	public function tambah_komentar_wisata() {
		// irsyad
		$this->load->model( 'komentar_wisata_m' );
		$this->load->model( 'wisata_m' );
		$this->load->model( 'pengguna_m' );

		if ( $this->POST( 'submit' ) ) {

			$this->data['komentar']	= [
				'id_wisata' 	=> $this->POST( 'id_wisata' ),
				'id_pengguna' 	=> $this->POST( 'id_pengguna' ),
				'komentar'		=> $this->POST( 'komentar' ),
				'created_at'	=> date("Y-m-d H:i:s"),
				'updated_at' 	=> date("Y-m-d H:i:s")
			];
			$this->komentar_wisata_m->insert( $this->data['komentar'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Komentar berhasil ditambahkan' );
			redirect( 'admin/data-komentar-wisata' );
			exit;

		}

		$this->data['wisata'] 		= $this->wisata_m->get();
		$this->data['pengguna']		= $this->pengguna_m->get();
		$this->data['title']		= 'Tambah Komentar Wisata';
		$this->data['content']		= 'admin/komentar_wisata_tambah';
		$this->template( $this->data, 'admin' );
	}

	public function edit_komentar_wisata() {
		// irsyad

		$this->data['id_komentar']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_komentar'] ) );

		$this->load->model( 'komentar_wisata_m' );
		$this->load->model( 'wisata_m' );
		$this->load->model( 'pengguna_m' );

		if ( $this->POST( 'edit' ) ) {

			$this->data['komentar']	= [
				'id_wisata' 	=> $this->POST( 'id_wisata' ),
				'id_pengguna' 	=> $this->POST( 'id_pengguna' ),
				'komentar'		=> $this->POST( 'komentar' ),
				'updated_at' 	=> date("Y-m-d H:i:s")
			];
			
			$this->komentar_wisata_m->update( $this->data['id_komentar'], $this->data['komentar'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Komentar berhasil di-edit' );
			redirect( 'admin/edit-komentar-wisata/' . $this->data['id_komentar'] );
			exit;

		}

		$this->data['komentar']		= $this->komentar_wisata_m->get_row([ 'id_komentar' => $this->data['id_komentar'] ]);
		$this->check_allowance( !isset( $this->data['id_komentar'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		$this->data['wisata'] 		= $this->wisata_m->get();
		$this->data['pengguna']		= $this->pengguna_m->get();
		$this->data['title']		= 'Edit Komentar Wisata';
		$this->data['content']		= 'admin/komentar_wisata_edit';
		$this->template( $this->data, 'admin' );
	}

	public function data_rating_wisata() {
		// irsyad
		$this->load->model( 'rating_wisata_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_rating']	= $this->uri->segment( 3 );
			$this->rating_wisata_m->delete( $this->data['id_rating'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-rating-wisata' );
			exit;

		}

		$this->data['rating']	= $this->rating_wisata_m->getDataJoin(['wisata','pengguna'], ['wisata.id_wisata=rating_wisata.id_wisata', 'pengguna.id_pengguna=rating_wisata.id_pengguna']);
		$this->data['title']	= 'Data Rating Wisata';
		$this->data['content']	= 'admin/rating_wisata_data';
		$this->template( $this->data, 'admin' );
	}

	public function tambah_rating_wisata() {
		// irsyad
		$this->load->model( 'wisata_m' );
		$this->load->model( 'pengguna_m' );

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'rating_wisata_m' );
			$this->data['rating'] = [
				'id_wisata' => $this->POST('id_wisata'),
				'id_pengguna' => $this->POST('id_pengguna'),
				'rating' => $this->POST('rating'),
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			];
			$this->rating_wisata_m->insert( $this->data['rating'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-rating-wisata' );
			exit;

		}

		$this->data['pengguna']		= $this->pengguna_m->get();
		$this->data['wisata'] 		= $this->wisata_m->get();
		$this->data['title']		= 'Tambah Rating Wisata';
		$this->data['content']		= 'admin/rating_wisata_tambah';
		$this->template( $this->data, 'admin' );
	}

	public function edit_rating_wisata() {
		// irsyad
	
		$this->data['id_rating']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_rating'] ) );

		$this->load->model( 'rating_wisata_m' );
		$this->load->model( 'wisata_m' );
		$this->load->model( 'pengguna_m' );

		if ( $this->POST( 'edit' ) ) {

			$this->data['rating']	= [
				'id_wisata' => $this->POST('id_wisata'),
				'id_pengguna' => $this->POST('id_pengguna'),
				'rating' => $this->POST('rating'),
				'updated_at' => date("Y-m-d H:i:s")
			];
			
			$this->rating_wisata_m->update( $this->data['id_rating'], $this->data['rating'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-rating-wisata/' . $this->data['id_rating'] );
			exit;

		}

		$this->data['rating']		= $this->rating_wisata_m->get_row([ 'id_rating' => $this->data['id_rating'] ]);
		$this->check_allowance( !isset( $this->data['rating'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		$this->data['wisata'] 		= $this->wisata_m->get();
		$this->data['pengguna']		= $this->pengguna_m->get();
		$this->data['title']		= 'Edit Rating Wisata';
		$this->data['content']		= 'admin/rating_wisata_edit';
		$this->template( $this->data, 'admin' );
	}

	public function data_kuesioner() {

		// abdi

		$this->load->model( 'kuesioner_m' );
		$this->load->model('wisata_m');
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_kuesioner']	= $this->uri->segment( 3 );
			$this->kuesioner_m->delete( $this->data['id_kuesioner'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-kuesioner' );
			exit;

		}

		$this->data['kuesioner']	= $this->kuesioner_m->get();
		$this->data['wisata'] = $this->wisata_m->get();
		$this->data['title']	= 'Data Kuesioner';
		$this->data['content']	= 'admin/kuesioner_data';
		$this->template( $this->data, 'admin' );


	}

	public function tambah_kuesioner() {

		// abdi

		$this->load->model( 'kuesioner_m' );
		$this->load->model( 'wisata_m' );

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'kuesioner_m' );
			$this->data['kuesioner'] = [
				'nama_kuesioner' => $this->POST('nama_kuesioner'),
				'id_wisata' => $this->POST('id_wisata')
			];
			$this->kuesioner_m->insert( $this->data['kuesioner'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-kuesioner' );
			exit;

		}

		$this->data['kuesioner']	= $this->kuesioner_m->get();
		$this->data['wisata'] 		= $this->wisata_m->get();
		$this->data['title']		= 'Tambah Kuesioner';
		$this->data['content']		= 'admin/kuesioner_tambah';
		$this->template( $this->data, 'admin' );

	}

	public function edit_kuesioner() {

		// abdi

		$this->data['id_kuesioner']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_kuesioner'] ) );

		$this->load->model( 'kuesioner_m' );
		$this->load->model( 'wisata_m' );

		if ( $this->POST( 'edit' ) ) {

			$this->data['kuesioner']	= [
				'nama_kuesioner' => $this->POST('nama_kuesioner'),
				'id_wisata' => $this->POST('id_wisata'),
				'updated_at' => date("Y-m-d H:i:s")
			];
			
			$this->kuesioner_m->update( $this->data['id_kuesioner'], $this->data['kuesioner'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-kuesioner/' . $this->data['id_kuesioner'] );
			exit;

		}

		$this->data['kuesioner']= $this->kuesioner_m->get_row([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);
		$this->check_allowance( !isset( $this->data['kuesioner'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		$this->data['wisata'] 		= $this->wisata_m->get();
		$this->data['title']		= 'Edit Kuesioner';
		$this->data['content']		= 'admin/kuesioner_edit';
		$this->template( $this->data, 'admin' );
	}

	public function data_pertanyaan_kuesioner() {

		// abdi
		$this->load->model( 'pertanyaan_kuesioner_m' );
		$this->load->model('kuesioner_m');
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_pertanyaan']	= $this->uri->segment( 3 );
			$this->pertanyaan_kuesioner_m->delete( $this->data['id_pertanyaan'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-pertanyaan-kuesioner' );
			exit;

		}

		$this->data['pertanyaan_kuesioner']	= $this->pertanyaan_kuesioner_m->get();
		$this->data['kuesioner'] = $this->kuesioner_m->get();
		$this->data['title']	= 'Data Kuesioner';
		$this->data['content']	= 'admin/pertanyaan_kuesioner_data';
		$this->template( $this->data, 'admin' );


	}

	public function tambah_pertanyaan_kuesioner() {

		$this->data['id_kuesioner'] = $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_kuesioner'] ) );

		$this->load->model( 'kuesioner_m' );
		$this->load->model( 'kuesioner_pertanyaan_kategori_m' );

		// if button with name=submit is clicked
		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'kuesioner_pertanyaan_m' );
			$this->load->model( 'kuesioner_jawaban_m' );
			
			// encapsulate question to be inserted
			$this->data['pertanyaan']	= [
				'pertanyaan'	=> $this->POST( 'pertanyaan' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
				'id_kuesioner'	=> $this->data['id_kuesioner'],
				'id_pertanyaan'	=> $this->__generate_random_id()
			];

			// insert question to kuesioner_pertanyaan table
			$this->kuesioner_pertanyaan_m->insert( $this->data['pertanyaan'] );

			// get last inserted primary key id
			$id_pertanyaan = $this->db->insert_id();

			// get jawaban and nilai data which passed as an array
			$jawaban 	= $this->POST( 'jawaban' );
			$nilai		= $this->POST( 'nilai' );

			// insert jawaban and nilai one by one
			for ( $i = 0; $i < count( $jawaban ) && $i < count( $nilai ); $i++ ) {

				$this->kuesioner_jawaban_m->insert([
					'id_pertanyaan'	=> $id_pertanyaan,
					'jawaban'		=> $jawaban[$i],
					'nilai'			=> $nilai[$i],
					'id_jawaban'	=> $this->__generate_random_id()
				]);

			}

			$this->flashmsg( '<i class="fa fa-check"></i> Pertanyaan kuesioner berhasil ditambahkan' );
			redirect( 'admin/pertanyaan-kuesioner/' . $this->data['id_kuesioner'] );
			exit;

		}

		$this->data['kategori']		= $this->kuesioner_pertanyaan_kategori_m->get();
		$this->data['kuesioner'] 	= $this->kuesioner_m->get_row([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);
		$this->data['title']		= 'Tambah Pertanyaan ' . $this->data['kuesioner']->nama_kuesioner;
		$this->data['content']		= 'admin/kuesioner_pertanyaan_tambah';
		$this->template( $this->data, 'admin' );
	}

	public function edit_pertanyaan_kuesioner() {

		// irsyad
		$this->data['id_pertanyaan'] = $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_pertanyaan'] ) );

		$this->load->model( 'kuesioner_pertanyaan_kategori_m' );
		$this->load->model( 'kuesioner_pertanyaan_m' );
		$this->load->model( 'kuesioner_m' );
		$this->load->model( 'kuesioner_jawaban_m' );

		// if button with name=edit is clicked
		if ( $this->POST( 'edit' ) ) {
			
			// encapsulate question to be inserted
			$this->data['pertanyaan']	= [
				'pertanyaan'	=> $this->POST( 'pertanyaan' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
			];

			// update question to kuesioner_pertanyaan table
			$this->kuesioner_pertanyaan_m->update( $this->data['id_pertanyaan'] , $this->data['pertanyaan'] );

			$this->flashmsg( '<i class="fa fa-check"></i> Pertanyaan kuesioner berhasil di edit' );
			redirect( 'admin/edit-pertanyaan-kuesioner/' . $this->data['id_pertanyaan'] );
			exit;

		}

		$this->data['kategori']		= $this->kuesioner_pertanyaan_kategori_m->get();
		$this->data['pertanyaan'] 	= $this->kuesioner_pertanyaan_m->get_row([ 'id_pertanyaan' => $this->data['id_pertanyaan'] ]);
		$this->data['kuesioner']	= $this->kuesioner_m->get_row([ 'id_kuesioner' => $this->data['pertanyaan']->id_kuesioner]);
		$this->data['jawaban'] 		= $this->kuesioner_jawaban_m->get([ 'id_pertanyaan' => $this->data['id_pertanyaan'] ]);
		$this->data['title']		= 'Edit Pertanyaan ' . $this->data['kuesioner']->nama_kuesioner;
		$this->data['content']		= 'admin/kuesioner_pertanyaan_edit';
		$this->template( $this->data, 'admin' );
	}

	public function data_jawaban_kuesioner() {

		// irsyad
		$this->load->model( 'kuesioner_jawaban_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_jawaban']	= $this->uri->segment( 3 );
			$this->kuesioner_jawaban_m->delete( $this->data['id_jawaban'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-jawaban-kuesioner' );
			exit;

		}

		$this->data['jawab']	= $this->kuesioner_jawaban_m->getDataJoin(['kuesioner_pertanyaan','kuesioner'], ['kuesioner_pertanyaan.id_pertanyaan=kuesioner_jawaban.id_pertanyaan', 'kuesioner.id_kuesioner=kuesioner_pertanyaan.id_kuesioner']);
		$this->data['title']	= 'Data Jawaban Kuesioner Wisata';
		$this->data['content']	= 'admin/kuesioner_jawaban_data';
		$this->template( $this->data, 'admin' );
	}

	public function tambah_jawaban_kuesioner() {

		// irsyad
		$this->load->model( 'kuesioner_pertanyaan_m' );
		$this->load->model( 'kuesioner_m' );
		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'kuesioner_jawaban_m' );
			$this->data['jawab'] = [
				'id_pertanyaan' => $this->POST( 'id_pertanyaan' ),
				'jawaban' 		=> $this->POST( 'jawaban' ),
				'nilai'			=> $this->POST( 'nilai' ),
			];
			$this->kuesioner_jawaban_m->insert( $this->data['jawab'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-jawaban-kuesioner' );
			exit;

		}

		$this->data['pertanyaan'] 	= $this->kuesioner_pertanyaan_m->get();
		$this->data['kuesioner']	= $this->kuesioner_m->get();
		$this->data['title']		= 'Tambah Jawaban Kuesioner Wisata';
		$this->data['content']		= 'admin/kuesioner_jawaban_tambah';
		$this->template( $this->data, 'admin' );
	}

	public function edit_jawaban_kuesioner() {

		// irsyad
		$this->data['id_jawaban']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_jawaban'] ) );

		$this->load->model( 'kuesioner_jawaban_m' );
		$this->load->model( 'kuesioner_pertanyaan_m' );
		$this->load->model( 'kuesioner_m' );

		if ( $this->POST( 'edit' ) ) {

			$this->data['jawab']	= [
				'id_pertanyaan' => $this->POST( 'id_pertanyaan' ),
				'jawaban' 		=> $this->POST( 'jawaban' ),
				'nilai'		 	=> $this->POST( 'nilai' ),
				'updated_at' 	=> date( "Y-m-d H:i:s" )
			];
			
			$this->kuesioner_jawaban_m->update( $this->data['id_jawaban'], $this->data['jawab'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-jawaban-kuesioner/' . $this->data['id_jawaban'] );
			exit;

		}

		$this->data['jawab']		= $this->kuesioner_jawaban_m->get_row([ 'id_jawaban' => $this->data['id_jawaban'] ]);
		$this->check_allowance( !isset( $this->data['jawab'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		$this->data['kuesioner']	= $this->kuesioner_m->get();
		$this->data['pertanyaan']	= $this->kuesioner_pertanyaan_m->get();
		$this->data['title']		= 'Edit Jawaban Kuesioner Wisata';
		$this->data['content']		= 'admin/kuesioner_jawaban_edit';
		$this->template( $this->data, 'admin' );

	}

	public function pertanyaan_kuesioner() {

		$this->data['id_kuesioner'] = $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_kuesioner'] ) );

		$this->load->model( 'kuesioner_m' );
		$this->data['kuesioner']	= $this->kuesioner_m->get_row([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);
		$this->check_allowance( !isset( $this->data['kuesioner'] ), [ 'Data not found', 'danger' ] );

		$this->load->model( 'kuesioner_jawaban_pengguna_m' );
		$this->data['overall_score'] = $this->kuesioner_jawaban_pengguna_m->get_overall_score( $this->data['id_kuesioner'] );

		$this->load->model( 'kuesioner_pertanyaan_m' );
		$this->data['pertanyaan'] = $this->kuesioner_pertanyaan_m->get([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);

		$this->load->model( 'kuesioner_pertanyaan_kategori_m' );
		$this->data['kategori'] = $this->kuesioner_pertanyaan_kategori_m->get();

		$this->data['title']	= 'Pertanyaan Kuesioner';
		$this->data['content']	= 'admin/kuesioner_pertanyaan_data';
		$this->template( $this->data, 'admin' );

	}

	public function data_event() {
		$this->load->model( 'event_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_event']		= $this->uri->segment( 3 );		
			$this->data['event']		= $this->event_m->get_row([ 'id_event' => $this->data['id_event'] ]);
			if ( isset( $this->data['id_event'] ) ) {

				$this->event_m->delete( $this->data['id_event'] );
				$imgs = json_decode( $this->data['event']->foto );
				foreach ( $imgs as $img ) {
					@unlink( realpath( FCPATH . '/assets/img/wisata/' . $img ) );
				}
				$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			
			} else {

				$this->flashmsg( '<i class="fa fa-times"></i> Data tidak ditemukan', 'danger' );
			}
			
			redirect( 'admin/data-event' );
			exit;
		}
		$this->data['event']	= $this->event_m->get();
		$this->data['title']	= 'Data Event';
		$this->data['content']	= 'admin/event_data';
		$this->template( $this->data, 'admin' );	
	}

	public function tambah_event() {
		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'event_m' );
			$id_event 	= $this->__generate_random_id();
			$num_img 	= $this->POST( 'num_img' );
			$foto		= [];
			for ( $i = 0; $i < $num_img; $i++ ) {
				
				$img_name = $id_event . '_' . pathinfo( $_FILES[ 'berkas' . ($i + 1) ]['name'], PATHINFO_FILENAME );
				$this->upload( $img_name, '/assets/img/wisata', 'berkas' . ($i + 1) );
				$foto []= $img_name . '.jpg';

			} 
			$this->data['event'] = [
				'id_event'		=> $id_event,
				'nama_event' 	=> $this->POST('nama_event'),
				'deskripsi'		=> $this->POST('deskripsi'),
				'foto'			=> json_encode( $foto )
			];
			$this->event_m->insert( $this->data['event'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-event' );
			exit;

		}
		$this->data['title']	= 'Tambah Event';
		$this->data['content']	= 'admin/event_tambah';
		$this->template( $this->data, 'admin' );

	}

	public function edit_event() {

		$this->data['id_event']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_event'] ) );

		$this->config->load( 'app' );
		$this->data['GOOGLE_MAPS_API_KEY'] = $this->config->item( 'GOOGLE_MAPS_API_KEY' );

		$this->load->model( 'event_m' );

		$this->data['event']		= $this->event_m->get_row([ 'id_event' => $this->data['id_event'] ]);
		$this->check_allowance( !isset( $this->data['event'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		

		if ( $this->POST( 'edit' ) ) {

			$num_img 		= $this->POST( 'num_img' );
			$deleted_photos	= $this->POST( 'deleted_photos' );
			$photos 		= json_decode( $this->data['event']->foto );

			if ( isset( $deleted_photos ) ) {
				$photos 		= array_diff( $photos, $deleted_photos );
				foreach ( $deleted_photos as $deleted ) {
					@unlink( FCPATH . '/assets/img/wisata/' . $deleted );
				}
			}

			for ( $i = 0; $i < $num_img; $i++ ) {

				if ( !empty( $_FILES['berkas' . ($i + 1)]['name'] ) ) {

					$img_name = $this->data['id_wisata'] . '_' . pathinfo( $_FILES[ 'berkas' . ($i + 1) ]['name'], PATHINFO_FILENAME );
					$this->upload( $img_name, '/assets/img/wisata', 'berkas' . ($i + 1) );
					$photos []= $img_name . '.jpg';

				}

			}


			$this->data['event']	= [
				'nama_event'	=> $this->POST( 'nama_event' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'foto'			=> json_encode( $photos )
			];

			$this->event_m->update( $this->data['id_event'], $this->data['event'] );
			$this->upload( $this->data['id_event'], '/assets/img/wisata', 'berkas' );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-event/'. $this->data['id_event'] );
			exit;

		}

		
		$this->data['title']			= 'Edit Event';
		$this->data['content']			= 'admin/event_edit';
		$this->template( $this->data, 'admin' );

	}

}