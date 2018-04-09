<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{

	public function __construct() {

		parent::__construct();
		$this->data['id_pengguna']	= $this->session->userdata( 'id_pengguna' );
		if ( isset( $this->data['id_pengguna'] ) ) {

			$this->data['role']	= $this->session->userdata( 'role' );
			switch ( $this->data['role'] ) {

				case 'admin':
					redirect( 'admin' );
					break;

				case 'mahasiswa':
					redirect( 'mahasiswa' );
					break;

			}

		}

	}

	public function index() {

		if ( $this->POST( 'login' ) ) {

			$this->load->model( 'login_m' );
			$pengguna = $this->login_m->login_mahasiswa( $this->POST( 'username' ), md5( $this->POST( 'password' ) ) );
			if ( $pengguna != NULL ) {

				$this->session->set_userdata([
					'id_pengguna'	=> $pengguna->id_pengguna,
					'id_lingkup'	=> $pengguna->id_lingkup,
					'role'			=> 'mahasiswa'
				]);

			} else {

				$this->flashmsg( 'Username atau password salah', 'danger' );

			}

			redirect( 'login' );
			exit;

		}

		$this->load->view('login');
		
	}

	public function admin() {

		if ( $this->POST( 'login' ) ) {

			$this->load->model( 'login_m' );
			$pengguna = $this->login_m->login_admin( $this->POST( 'username' ), md5( $this->POST( 'password' ) ) );
			if ( $pengguna != NULL ) {

				$this->session->set_userdata([
					'id_pengguna'	=> $pengguna->id_pengguna,
					'id_lingkup'	=> $pengguna->id_lingkup,
					'role'			=> 'admin'
				]);

			} else {

				$this->flashmsg( 'Username atau password salah', 'danger' );

			}

			redirect( 'login/admin' );
			exit;

		}

		$this->load->view('login_admin');

	}

}