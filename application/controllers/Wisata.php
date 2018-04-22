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

	public function kategori() {

		$this->load->model( 'kategori_wisata_m' );
		$this->data['kategori']	= $this->kategori_wisata_m->get();
		$this->data['title']	= 'Kategori Wisata';
		$this->data['content']	= 'wisata/wisata_kategori';
		$this->template( $this->data, 'wisata' );

	}

	public function daftar() {

		$this->data['id_kategori']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_kategori'] ) );

		$this->load->model( 'kategori_wisata_m' );
		$this->data['kategori']	= $this->kategori_wisata_m->get_row([ 'id_kategori' => $this->data['id_kategori'] ]);
		$this->check_allowance( !isset( $this->data['kategori'] ), [ 'Kategori tidak ditemukan', 'danger' ] );

		$this->load->model( 'wisata_m' );
		$this->data['wisata']	= $this->wisata_m->get([ 'id_kategori' => $this->data['id_kategori'] ]);
		$this->data['title']	= $this->data['kategori']->nama_kategori;
		$this->data['content']	= 'wisata/wisata_daftar';
		$this->template( $this->data, 'wisata' );

	}

	public function detail() {

		$this->data['id_wisata']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_wisata'] ) );

		$this->load->model( 'wisata_m' );
		$this->data['wisata']		= $this->wisata_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);
		$this->check_allowance( !isset( $this->data['wisata'] ), [ 'Data wisata tidak ditemukan', 'danger' ] );

		$this->data['foto']	= json_decode( $this->data['wisata']->foto );

		$this->config->load( 'app' );
		$this->data['GOOGLE_MAPS_API_KEY']	= $this->config->item( 'GOOGLE_MAPS_API_KEY' );
		$this->data['title']				= $this->data['wisata']->nama_wisata;
		$this->data['content']				= 'wisata/wisata_detail';
		$this->template( $this->data, 'wisata' );


	}

	public function galeri() {

		echo 'Galeri';

	}

	public function tentang() {

		echo 'Tentang';

	}

	public function kontak() {

		echo 'Kontak';

	}


}