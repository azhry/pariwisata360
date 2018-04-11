<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Wisata extends MY_Controller {

	public function __construct() {

		parent::__construct();

	}

	public function index() {

		$this->data['title']	= 'Tempat Wisata';
		$this->data['content']	= 'wisata/home';
		$this->template( $this->data, 'wisata' );

	}


}