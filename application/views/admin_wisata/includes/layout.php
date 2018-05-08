<?php 

$this->load->view( 'admin_wisata/includes/header', [ 'title' => $title ] );
$this->load->view( 'admin_wisata/includes/navbar' );
$this->load->view( 'admin_wisata/includes/sidebar' );
$this->load->view( $content );
$this->load->view( 'admin_wisata/includes/footer' );