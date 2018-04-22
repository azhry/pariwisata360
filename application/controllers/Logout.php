<?php 

class Logout extends MY_Controller {

	public function __construct() {

		parent::__construct();

		$this->session->sess_destroy();
		$redirect_to = 'auth';
		redirect( $redirect_to );
		exit;

	}

	public function index() {}

}