<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Wisata_m extends MY_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->data['table_name']	= 'wisata';
		$this->data['primary_key']	= 'id_wisata';
	}

	public function get_komentar_rating($id_wisata)
	{
		$this->db->select('*')
			->from('pengguna')
			->join('komentar_wisata', 'pengguna.id_pengguna = komentar_wisata.id_pengguna')
			->join('rating_wisata', 'komentar_wisata.id_pengguna = rating_wisata.id_pengguna', 'left')
			->where(['komentar_wisata.id_wisata' => $id_wisata]);
		$query = $this->db->get();
		return $query->result();
	}

}