<?php 

class Kepala_dinas extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['id_pengguna']	= $this->session->userdata( 'id_pengguna' );
		if ( !isset( $this->data['id_pengguna'] ) ) {

			$this->session->sess_destroy();
			$this->flashmsg( 'Anda tidak memiliki hak akses untuk halaman tersebut', 'danger' );
			redirect( 'auth' );

		}

		$this->data['hak_akses']	= $this->session->userdata( 'hak_akses' );
		if ($this->data['hak_akses'] != 'Kepala Dinas')
		{
			redirect('auth');
		}
	}

	public function index() 
	{
		$this->load->model( 'wisata_m' );
		$this->data['wisata']	= $this->wisata_m->get();
		$this->data['title']	= 'Data Wisata';
		$this->data['content']	= 'kepala_dinas/wisata_data';
		$this->template( $this->data, 'kepala_dinas' );
	}

	public function detail_wisata()
	{
		$this->data['id_wisata']	= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_wisata'] ) );

		$this->load->model('wisata_m');
		$this->data['wisata']	= $this->wisata_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);
		$this->check_allowance( !isset( $this->data['wisata'] ) );

		$this->load->model('komentar_wisata_m');
		$this->load->model('kuesioner_m');
		$this->load->model('kuesioner_jawaban_pengguna_m');
		$this->load->model('kuesioner_pertanyaan_kategori_m');
		$this->load->model('rating_wisata_m');

		$this->data['rating']		= $this->rating_wisata_m->getAvgRating($this->data['id_wisata']);
		$this->data['kuesioner']	= $this->kuesioner_m->get([ 'id_wisata' => $this->data['id_wisata'] ]);
		$this->data['kategori'] 	= $this->kuesioner_pertanyaan_kategori_m->get();
		$this->data['komentar']		= $this->komentar_wisata_m->get(['id_wisata' => $this->data['id_wisata']]);
		$this->data['title']		= 'Detail Wisata';
		$this->data['content']		= 'kepala_dinas/wisata_detail';
		$this->template($this->data, 'kepala_dinas');
	}	
}