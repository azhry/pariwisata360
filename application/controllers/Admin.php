<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin extends MY_Controller {

	public function __construct() {

		parent::__construct();

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

	}

	public function tambah_wisata() {

		// abdi
		// buat file baru wisata_tambah.php di ./views/admin

	}

	public function edit_wisata() {

		// abdi
		// buat file baru wisata_edit.php di ./views/admin

	}

	public function data_hak_akses() {

		// irsyad
		// buat file baru hak_akses_data.php di ./views/admin

	}

	public function tambah_hak_akses() {

		// irsyad
		// buat file baru hak_akses_tambah.php di ./views/admin

	}

	public function edit_hak_akses() {

		// irsyad
		// buat file baru hak_akses_edit.php di ./views/admin

	}

}