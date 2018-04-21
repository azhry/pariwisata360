<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Kuesioner_m extends MY_Model {

	public function __construct() {

		parent::__construct();
		$this->data['table_name']	= 'kuesioner';
		$this->data['primary_key']	= 'id_kuesioner';

	}

}