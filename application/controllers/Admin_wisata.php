<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin_wisata extends MY_Controller {

	public function __construct() {

		parent::__construct();
		$this->data['id_pengguna']	= $this->session->userdata( 'id_pengguna' );
		if ( !isset( $this->data['id_pengguna'] ) ) {

			$this->session->sess_destroy();
			$this->flashmsg( 'Anda tidak memiliki hak akses untuk halaman tersebut', 'danger' );
			redirect( 'auth' );
			exit;

		}

		$this->data['hak_akses']	= $this->session->userdata( 'hak_akses' );

	}

	public function index() {

		$this->data['title']			= 'Dashboard';
		$this->data['content']			= 'admin_wisata/dashboard';
		$this->template( $this->data, 'admin_wisata' );

	}

	public function data_wisata() {

		$this->config->load( 'app' );
		$this->data['GOOGLE_MAPS_API_KEY'] = $this->config->item( 'GOOGLE_MAPS_API_KEY' );

		$this->load->model( 'hak_akses_m' );
		$this->load->model( 'wisata_m' );
		$this->load->model( 'kategori_wisata_m' );

		$this->data['wisata']		= $this->wisata_m->get_row([ 'id_admin' => $this->data['id_pengguna'] ]);
		$this->check_allowance( !isset( $this->data['wisata'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		$this->data['id_wisata']	= $this->data['wisata']->id_wisata;

		if ( $this->POST( 'edit' ) ) {

			$num_img 		= $this->POST( 'num_img' );
			$deleted_photos	= $this->POST( 'deleted_photos' );
			$photos 		= json_decode( $this->data['wisata']->foto );

			if ( isset( $deleted_photos ) ) {
				$photos 		= array_diff( $photos, $deleted_photos );
				foreach ( $deleted_photos as $deleted ) {
					@unlink( FCPATH . '/assets/img/wisata/' . $deleted );
				}
			}

			for ( $i = 0; $i < $num_img; $i++ ) {

				if ( !empty( $_FILES['berkas' . ($i + 1)]['name'] ) ) {

					$img_name = $this->data['id_wisata'] . '_' . pathinfo( $_FILES[ 'berkas' . ($i + 1) ]['name'], PATHINFO_FILENAME );
					$this->upload( $img_name, '/assets/img/wisata', 'berkas' . ($i + 1) );
					$photos []= $img_name . '.jpg';

				}

			}


			$this->data['wisata']	= [
				'nama_wisata'	=> $this->POST( 'nama_wisata' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'foto'			=> json_encode( $photos ),
				'latitude'		=> $this->POST( 'latitude' ),
				'longitude'		=> $this->POST( 'longitude' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
				'updated_at'	=> date( 'Y-m-d H:i:s' )
			];

			if ( !empty( $_FILES['thumbnail']['name'] ) ) {

				@unlink( FCPATH . '/assets/img/thumbnail/' . $this->data['wisata']->thumbnail );
				$img_name = $this->data['id_wisata'] . '_' . pathinfo( $_FILES['thumbnail']['name'], PATHINFO_FILENAME );
				$this->upload( $img_name, '/assets/img/thumbnail', 'thumbnail' );
				$thumbnail = $img_name . '.jpg';
				$this->data['wisata']['thumbnail'] = $thumbnail;

			}

			$this->wisata_m->update( $this->data['id_wisata'], $this->data['wisata'] );
			$this->upload( $this->data['id_wisata'], '/assets/img/wisata', 'berkas' );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin-wisata/data-wisata' );
			exit;

		}

		$this->data['data_kategori']	= $this->kategori_wisata_m->get();
		$this->data['kategori']			= [];
		foreach ( $this->data['data_kategori'] as $kategori ) $this->data['kategori'][$kategori->id_kategori] = $kategori->nama_kategori;

		$this->data['hak_akses']		= $this->hak_akses_m->get();
		$this->data['title']			= 'Edit Wisata';
		$this->data['content']			= 'admin_wisata/wisata_edit';
		$this->template( $this->data, 'admin_wisata' );

	}	

	public function data_event() {

	}

	public function tambah_event() {

	}

	public function edit_event() {

	}

}