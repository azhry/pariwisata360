<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Profil extends MY_Controller {

	public function __construct() {

		parent::__construct();
		$this->data['id_pengguna']	= $this->session->userdata( 'id_pengguna' );
		if ( !isset( $this->data['id_pengguna'] ) ) {

			$this->session->sess_destroy();
			$this->flashmsg( 'Anda tidak memiliki hak akses untuk halaman tersebut', 'danger' );
			redirect( 'auth' );
			exit;

		}


	}

	public function index() {
		
		$this->load->model( 'pengguna_m' );
		$this->data['pengguna']		= $this->pengguna_m->get_row([ 'id_pengguna' => $this->data['id_pengguna'] ]);
		$this->check_allowance( !isset( $this->data['pengguna'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );

		if ( $this->POST( 'edit' ) ) {

			@unlink( FCPATH . '/assets/img/profil/' . $this->data['pengguna']->foto );

			$img_name = $this->data['id_pengguna'] . '_' . pathinfo( $_FILES['berkas']['name'], PATHINFO_FILENAME );
			$img_name = str_replace(" ", "_", $img_name);
			$this->upload( $img_name, '/assets/img/profil/', 'berkas' );
			$img_name .= '.jpg';
			$this->data['pengguna']	= [
				'foto'			=> $img_name,	
				'email'			=> $this->POST( 'email' ),
				'nama'			=> $this->POST( 'nama' ),
				'tempat_lahir'	=> $this->POST( 'tempat_lahir' ),
				'tanggal_lahir'	=> $this->POST( 'tanggal_lahir' )
			];
			$password = $this->POST( 'password' );
			if ( !empty( $password ) ) $this->data['pengguna']['password'] = md5( $password );
			$this->pengguna_m->update( $this->data['id_pengguna'], $this->data['pengguna'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'profil' );
			exit;

		}

		$this->data['title']			= 'Profil';
		$this->data['content']			= 'profil/profil_data';
		$this->template( $this->data, 'profil' );

	}

}