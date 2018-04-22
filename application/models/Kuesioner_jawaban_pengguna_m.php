<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Kuesioner_jawaban_pengguna_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'kuesioner_jawaban_pengguna';
		$this->data['primary_key']	= 'id_jawaban_pengguna';

	}

	public function get_overall_score( $id_kuesioner ) {

		$this->db->select( '*, AVG(kuesioner_jawaban.nilai) AS overall' )
			->from( 'kuesioner_pertanyaan_kategori' )
			->join( 'kuesioner_pertanyaan', 'kuesioner_pertanyaan_kategori.id_kategori = kuesioner_pertanyaan.id_kategori', 'left' )
			->join( $this->data['table_name'], 'kuesioner_pertanyaan.id_pertanyaan = ' . $this->data['table_name'] . '.id_pertanyaan', 'left' )
			->join( 'kuesioner_jawaban', $this->data['table_name'] . '.id_jawaban = kuesioner_jawaban.id_jawaban', 'left' )
			->group_by( 'kuesioner_pertanyaan.id_kategori' )
			->where([ 'kuesioner_pertanyaan.id_kuesioner' => $id_kuesioner ]);
		$query = $this->db->get();
		return $query->result();

	}

}