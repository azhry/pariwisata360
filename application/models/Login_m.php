<?php 

class Login_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'admin';
		$this->data['primary_key']	= 'nik';

	}

	public function login_admin( $username, $password ) {

		$pengguna = $this->get_row( [ 'nik' => $username, 'password' => $password ] );
		if ( $pengguna ) {

			return $pengguna;

		}

		return NULL;

	}

	public function login_mahasiswa( $username, $password ) {

		$this->data['table_name']	= 'mahasiswa';
		$this->data['primary_key']	= 'nim';
		$pengguna = $this->get_row( [ 'nim' => $username, 'password' => $password ] );
		if ( $pengguna ) {

			return $pengguna;

		}

		return NULL;

	}

}