<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Kuesioner_pertanyaan_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'kuesioner_pertanyaan';
		$this->data['primary_key']	= 'id_pertanyaan';

	}

}