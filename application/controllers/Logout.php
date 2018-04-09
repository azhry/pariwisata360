<?php 

class Logout extends MY_Controller {

	public function __construct() {

		parent::__construct();

		$redirect_to = 'login';
		$this->data['role']	= $this->session->userdata( 'role' );
		if ( $this->data['role'] == 'admin' ) {
			$redirect_to .= '/admin';
		}
		$this->session->sess_destroy();
		redirect( $redirect_to );
		exit;

	}

	public function index() {}

}