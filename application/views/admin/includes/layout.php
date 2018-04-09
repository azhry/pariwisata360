<?php 

$this->load->view( 'admin/includes/header', [ 'title' => $title ] );
$this->load->view( 'admin/includes/navbar' );
$this->load->view( 'admin/includes/sidebar' );
$this->load->view( $content );
$this->load->view( 'admin/includes/footer' );