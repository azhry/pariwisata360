<?php 

$this->load->view( 'wisata/includes/header', [ 'title' => $title ] );
$this->load->view( 'wisata/includes/navbar' );
$this->load->view( 'wisata/includes/sidebar' );
$this->load->view( $content );
$this->load->view( 'wisata/includes/footer' );