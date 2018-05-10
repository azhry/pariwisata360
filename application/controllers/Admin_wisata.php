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

			$this->data['wisata']	= [
				'nama_wisata'	=> $this->POST( 'nama_wisata' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'latitude'		=> $this->POST( 'latitude' ),
				'longitude'		=> $this->POST( 'longitude' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
				'updated_at'	=> date( 'Y-m-d H:i:s' )
			];
			$this->wisata_m->update( $this->data['id_wisata'], $this->data['wisata'] );
			$this->upload( $this->data['id_wisata'], '/assets/img/wisata', 'berkas' );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin-wisata/edit-wisata/' . $this->data['id_wisata'] );
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
		
		$this->load->model( 'event_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_event']		= $this->uri->segment( 3 );		
			$this->data['event']		= $this->event_m->get_row([ 'id_event' => $this->data['id_event'] ]);
			if ( isset( $this->data['id_event'] ) ) {

				$this->event_m->delete( $this->data['id_event'] );
				$imgs = json_decode( $this->data['event']->foto );
				foreach ( $imgs as $img ) {
					@unlink( realpath( FCPATH . '/assets/img/wisata/' . $img ) );
				}
				$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			
			} else {

				$this->flashmsg( '<i class="fa fa-times"></i> Data tidak ditemukan', 'danger' );
			}
			
			redirect( 'admin/data-event' );
			exit;

		}

		$this->data['event']	= $this->event_m->get();
		$this->data['title']	= 'Data Event';
		$this->data['content']	= 'admin_wisata/event_data';
		$this->template( $this->data, 'admin_wisata' );	
		
	}

	public function tambah_event() {

		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'event_m' );
			$id_event 	= $this->__generate_random_id();
			$num_img 	= $this->POST( 'num_img' );
			$foto		= [];
			for ( $i = 0; $i < $num_img; $i++ ) {
				
				$img_name = $id_event . '_' . pathinfo( $_FILES[ 'berkas' . ($i + 1) ]['name'], PATHINFO_FILENAME );
				$this->upload( $img_name, '/assets/img/wisata', 'berkas' . ($i + 1) );
				$foto []= $img_name . '.jpg';

			} 
			$this->data['event'] = [
				'id_event'		=> $id_event,
				'nama_event' 	=> $this->POST('nama_event'),
				'deskripsi'		=> $this->POST('deskripsi'),
				'foto'			=> json_encode( $foto )
			];
			$this->event_m->insert( $this->data['event'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil ditambahkan' );
			redirect( 'admin-wisata/data-event' );
			exit;

		}
		$this->data['title']	= 'Tambah Event';
		$this->data['content']	= 'admin_wisata/event_tambah';
		$this->template( $this->data, 'admin_wisata' );
	}

	public function edit_event() {

		$this->data['id_event']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_event'] ) );

		$this->load->model( 'event_m' );
		
		if ( $this->POST( 'edit' ) ) {

			$this->data['event'] = [				
				'nama_event' 	=> $this->POST('nama_event'),
				'deskripsi'		=> $this->POST('deskripsi')
			];
			$this->event_m->update( $this->data['id_event'], $this->data['event'] );
			$this->upload( $this->data['id_event'], '/assets/img/wisata', 'berkas' );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin-wisata/edit-event/' . $this->data['id_event'] );
			exit;

		}
		$this->data['event']	= $this->event_m->get_row([ 'id_event' => $this->data['id_event'] ]);
		$this->data['title']	= 'Edit Event';
		$this->data['content']	= 'admin_wisata/event_edit';
		$this->template( $this->data, 'admin_wisata' );
	}

}