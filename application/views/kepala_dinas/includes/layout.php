<?php 

$this->load->view( 'kepala_dinas/includes/header', [ 'title' => $title ] );
$this->load->view( 'kepala_dinas/includes/navbar' );
$this->load->view( 'kepala_dinas/includes/sidebar' );
$this->load->view( $content );
$this->load->view( 'kepala_dinas/includes/footer' );