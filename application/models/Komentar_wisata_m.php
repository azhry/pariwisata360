<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Komentar_wisata_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'komentar_wisata';
		$this->data['primary_key']	= 'id_komentar';

	}

	public function get_komentar( $id_wisata ) {

		$this->db->select( '*' );
		$this->db->from( $this->data['table_name'] );
		$this->db->join( 'pengguna', $this->data['table_name'] . '.id_pengguna = pengguna.id_pengguna' );
		$this->db->where([ $this->data['table_name'] . '.id_wisata' => $id_wisata ]);
		$query = $this->db->get();
		return $query->result();

	}

	public function get_all_komentar() {

		$this->db->select( '*' );
		$this->db->from( $this->data['table_name'] );
		$this->db->join( 'pengguna', $this->data['table_name'] . '.id_pengguna = pengguna.id_pengguna' );
		$query = $this->db->get();
		return $query->result();

	}

}