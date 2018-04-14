<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Rating_wisata_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'rating_wisata';
		$this->data['primary_key']	= 'id_rating';

	}

}