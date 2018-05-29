<?php 

$this->load->view( 'profil/includes/header', [ 'title' => $title ] );
$this->load->view( 'profil/includes/navbar' );
$this->load->view( 'profil/includes/sidebar' );
$this->load->view( $content );
$this->load->view( 'profil/includes/footer' );