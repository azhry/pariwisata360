<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

	public function __construct() {

		parent::__construct();
		$this->data['id_pengguna']	= $this->session->userdata( 'id_pengguna' );
		if ( isset( $this->data['id_pengguna'] ) ) {

			$this->data['hak_akses']	= $this->session->userdata( 'hak_akses' );
			switch ( $this->data['hak_akses'] ) {

				case 'Admin':
					redirect( 'admin' );
					break;

				case 'Admin Wisata':
					redirect( 'admin-wisata' );
					break;

				case 'Pengunjung':
					redirect( 'wisata' );
					break;

			}

		}


	}

	public function index() {

		if ( $this->POST( 'login' ) ) {

			$this->load->model( 'login_m' );
			$pengguna = $this->login_m->login( $this->POST( 'email' ), md5( $this->POST( 'password' ) ) );
			if ( $pengguna != NULL ) {

				$this->load->model( 'hak_akses_m' );
				$hak_akses = $this->hak_akses_m->get_row([ 'id_hak_akses' => $pengguna->id_hak_akses ]);
				if ( $hak_akses ) {

					$this->session->set_userdata([
						'id_pengguna'	=> $pengguna->id_pengguna,
						'hak_akses'		=> $hak_akses->label
					]);

				} else {

					$this->flashmsg( 'Hak akses tidak ditemukan', 'danger' );

				}

			} else {

				$this->flashmsg( 'Email atau password salah', 'danger' );

			}

			redirect( 'auth' );

		} else if ( $this->POST( 'register' ) ) {

			$password 			= md5( $this->POST( 'password' ) );
			$confirm_password	= md5( $this->POST( 'confirm_password' ) );
			if ( $password === $confirm_password ) {

				$this->load->model( 'pengguna_m' );
				$id_pengguna = $this->__generate_random_id();
			
				$img_name = $id_pengguna . '_' . pathinfo( $_FILES['berkas']['name'], PATHINFO_FILENAME );
				$img_name = str_replace(" ", "_", $img_name);
				$this->upload( $img_name, '/assets/img/profil/', 'berkas' );
				$img_name .= '.jpg';
				$this->data['pengguna'] = [
					'id_pengguna'	=> $id_pengguna,
					'id_hak_akses'	=> 3,
					'email'			=> $this->POST( 'email' ),
					'password'		=> $password,
					'nama'			=> $this->POST( 'nama' ),
					'tempat_lahir'	=> $this->POST( 'tempat_lahir' ),
					'tanggal_lahir'	=> $this->POST( 'tanggal_lahir' ),
					'foto'			=> $img_name
				];
				$this->pengguna_m->insert( $this->data['pengguna'] );
				$this->flashmsg( 'Pendaftaran berhasil. Silahkan login menggunakan akun yang telah didaftarkan' );

			} else {

				$this->flashmsg( 'Password harus sama dengan confirm password', 'danger' );

			}

			redirect( 'auth' );

		}

		$this->load->view('login');
		
	}

}