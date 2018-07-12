<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Rating_wisata_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'rating_wisata';
		$this->data['primary_key']	= 'id_rating';

	}

	public function getAvgRating($id_wisata)
	{
		$this->db->select('AVG(rating) AS rating')
			->from($this->data['table_name'])
			->where(['id_wisata' => $id_wisata])
			->group_by('id_wisata');
		$query = $this->db->get();
		return $query->row();
	}

}