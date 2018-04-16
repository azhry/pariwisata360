<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin extends MY_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	public function index() {

		echo 'Dashboard admin';

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
				'id_kategori'	=> $this->POST( 'id_kategori' )
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

		if ( $this->POST( 'edit' ) ) {

			$this->data['wisata']	= [
				'nama_wisata'	=> $this->POST( 'nama_wisata' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'latitude'		=> $this->POST( 'latitude' ),
				'longitude'		=> $this->POST( 'longitude' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
				'updated_at'	=> date( 'Y-m-d H:i:s' )
			];
			$this->wisata_m->update( $this->data['id_wisata'], $this->data['wisata'] );
			$this->upload( $this->data['id_wisata'], '/assets/img/wisata', 'berkas' );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-wisata/' . $this->data['id_wisata'] );
			exit;

		}

		$this->data['wisata']		= $this->wisata_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);
		$this->check_allowance( !isset( $this->data['wisata'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );

		$this->data['data_kategori']	= $this->kategori_wisata_m->get();
		$this->data['kategori']			= [];
		foreach ( $this->data['data_kategori'] as $kategori ) $this->data['kategori'][$kategori->id_kategori] = $kategori->nama_kategori;

		$this->data['hak_akses']		= $this->hak_akses_m->get();
		$this->data['title']			= 'Edit Wisata';
		$this->data['content']			= 'admin/wisata_edit';
		$this->template( $this->data, 'admin' );

	}

	//Upload
	// public function aksi_upload(){
	// 	$config['upload_path']          = './gambar/';
	// 	$config['allowed_types']        = 'gif|jpg|png';
	// 	$config['max_size']             = 200;
	// 	$config['max_width']            = 1024;
	// 	$config['max_height']           = 768;
 
	// 	$this->load->library('upload', $config);
 
	// 	if ( ! $this->upload->do_upload('berkas')){
	// 		$error = array('error' => $this->upload->display_errors());
	// 		$this->load->view('wisata_tambah', $error);
	// 	}else{
	// 		$data = array('upload_data' => $this->upload->data());
	// 		$this->load->view('wisata_tambah_sukses', $data);
	// 	}
	// }

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

			$this->data['id_kategori']	= $this->uri->segment( 3 );
			$this->kategori_wisata_m->delete( $this->data['id_kategori'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin/data-kategori-wisata' );
			exit;

		}

		$this->data['kategori_wisata']	= $this->kategori_wisata_m->get();
		$this->data['title']	= 'Data Kategori';
		$this->data['content']	= 'admin/kategori_data';
		$this->template( $this->data, 'admin' );
		
	}

	public function tambah_kategori_wisata() {
		// abdi
		$this->load->model( 'kategori_wisata_m' );
		$this->data['kategori_wisata']	= $this->kategori_wisata_m->get();

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'kategori_wisata_m' );
			$this->data['kategori_wisata'] = [
				'id_kategori'	=> $this->POST('id_kategori'),
				'nama_kategori'	=> $this->POST( 'nama_kategori' ),
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
		

		if ( $this->POST( 'edit' ) ) {

			$this->data['kategori']	= [
				'id_kategori' => $this->POST('id_kategori'),
				'nama_kategori' => $this->POST('nama_kategori'),
				'deskripsi' => $this->POST('deskripsi'),
				'updated_at' => date("Y-m-d H:i:s")
			];
			
			$this->kategori_wisata_m->update( $this->data['id_kategori'], $this->data['kategori'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/data-kategori-wisata/' . $this->data['id_kategori'] );
			exit;

		}

		$this->data['kategori']		= $this->kategori_wisata_m->get_row([ 'id_kategori' => $this->data['id_kategori'] ]);
		$this->check_allowance( !isset( $this->data['kategori'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
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

}