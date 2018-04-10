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
			$this->wisata_m->delete( $this->data['id_wisata'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
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

		$this->load->model( 'hak_akses_m' );
		$this->data['hak_akses']	= $this->hak_akses_m->get();

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'wisata_m' );
			$this->data['wisata'] = [
				'id_wisata'	=> $this->__generate_random_id(),
				'nama_wisata'	=> $this->POST( 'nama_wisata' ),
				'deskripsi'			=> $this->POST( 'deskripsi' ),
				'foto'		=> md5( $this->POST( 'foto' ) ),
				'latitude'			=> $this->POST( 'latitude' ),
				'longitude'	=> $this->POST( 'longitude' ),
				'created_at'	=> $this->POST( 'created_at' ),
				'updated_at'	=> $this->POST( 'updated_at' )
			];
			$this->wisata_m->insert( $this->data['wisata'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin/data-wisata' );
			exit;

		}

		$this->data['title']		= 'Tambah Wisata';
		$this->data['content']		= 'admin/wisata_tambah';
		$this->template( $this->data, 'admin' );

	}

	public function edit_wisata() {

		// abdi
		// buat file baru wisata_edit.php di ./views/admin

		$this->data['id_wisata']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_wisata'] ) );

		$this->load->model( 'hak_akses_m' );
		$this->load->model( 'wisata_m' );

		if ( $this->POST( 'edit' ) ) {

			$this->data['wisata']	= [
				'id_wisata'	=> $this->POST( 'id_wisata' ),
				'nama_wisata'			=> $this->POST( 'nama_wisata' ),
				'deskripsi'			=> $this->POST( 'deskripsi' ),
				'foto'	=> $this->POST( 'foto' ),
				'latitude'	=> $this->POST( 'latitude' ),
				'longitude'	=> $this->POST( 'longitude' ),
				'updated_at'	=> date( 'Y-m-d H:i:s' )
			];
			$password = $this->POST( 'password' );
			if ( !empty( $password ) ) $this->data['pengguna']['password'] = md5( $password );
			$this->wisata_m->update( $this->data['id_wisata'], $this->data['wisata'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin/edit-wisata/' . $this->data['id_wisata'] );
			exit;

		}

		$this->data['wisata']		= $this->wisata_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);
		$this->check_allowance( !isset( $this->data['wisata'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );

		$this->data['hak_akses']	= $this->hak_akses_m->get();
		$this->data['title']		= 'Edit Wisata';
		$this->data['content']		= 'admin/wisata_edit';
		$this->template( $this->data, 'admin' );

	}

	//Upload
	public function aksi_upload(){
		$config['upload_path']          = './gambar/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 200;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
 
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('berkas')){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('wisata_tambah', $error);
		}else{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('wisata_tambah_sukses', $data);
		}
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

}