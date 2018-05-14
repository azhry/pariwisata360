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

		$this->load->model( 'komentar_wisata_m' );
		$this->data['komentar_wisata']	= $this->komentar_wisata_m->get_komentar( $this->data['id_wisata'] );

		if ( $this->POST( 'submit_komentar' ) ) {

			if ( $this->session->userdata( 'id_pengguna' ) && $this->session->userdata( 'hak_akses' ) ) {

				$this->data['komentar'] = [
					'id_pengguna'	=> $this->session->userdata( 'id_pengguna' ),
					'id_wisata'		=> $this->data['id_wisata'],
					'komentar'		=> $this->POST( 'komentar' )
				];
				$this->komentar_wisata_m->insert( $this->data['komentar'] );
				$this->flashmsg( 'Komentar berhasil ditambahkan' );

			} else {

				$this->flashmsg( 'Anda harus login terlebih dahulu <a href="' . base_url( 'auth' ) . '">disini</a> sebelum memberikan komentar', 'warning' );

			}

			redirect( 'wisata/detail/' . $this->data['id_wisata'] );
			exit;

		}

		$this->load->model( 'rating_wisata_m' );

		if ( $this->POST( 'beri_rating' ) ) {

			$response['error'] = false;
			if ( $this->session->userdata( 'id_pengguna' ) && $this->session->userdata( 'hak_akses' ) ) {

				$check_rating = $this->rating_wisata_m->get_row([ 'id_wisata' => $this->data['id_wisata'], 'id_pengguna' => $this->session->userdata( 'id_pengguna' ) ]);
				if ( $check_rating ) {

					$this->rating_wisata_m->update($check_rating->id_rating, [
						'rating'		=> $this->POST( 'rating' ),
						'updated_at'	=> date( 'Y-m-d H:i:s' )
					]);

				} else {

					$this->rating_wisata_m->insert([
						'id_wisata'		=> $this->data['id_wisata'],
						'id_pengguna'	=> $this->session->userdata( 'id_pengguna' ),
						'rating'		=> $this->POST( 'rating' )
					]);

				}

				$response['msg'] = 'Terima kasih atas rating yang telah diberikan';

			} else {

				$response['msg'] = 'Anda harus login terlebih dahulu <a href="' . base_url( 'auth' ) . '">disini</a> sebelum memberikan rating';

			}

			echo json_encode( $response );
			exit;

		}

		$this->data['foto']	= json_decode( $this->data['wisata']->foto );
		$this->load->model( 'kuesioner_m' );
		$this->data['kuesioner'] = $this->kuesioner_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);

		$this->config->load( 'app' );
		$this->data['GOOGLE_MAPS_API_KEY']	= $this->config->item( 'GOOGLE_MAPS_API_KEY' );
		$this->data['title']				= $this->data['wisata']->nama_wisata;
		$this->data['content']				= 'wisata/wisata_detail';
		$this->template( $this->data, 'wisata' );


	}

	public function kuesioner() {

		$this->data['id_kuesioner'] = $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_kuesioner'] ) );

		$this->load->model( 'kuesioner_m' );
		$this->data['kuesioner'] = $this->kuesioner_m->get_row([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);
		$this->check_allowance( !isset( $this->data['kuesioner'] ), [ 'Data not found', 'danger' ] );

		$this->load->model( 'kuesioner_pertanyaan_m' );
		$this->data['pertanyaan']	= $this->kuesioner_pertanyaan_m->get([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);
		$this->load->model( 'kuesioner_jawaban_m' );
		$this->load->model( 'kuesioner_jawaban_pengguna_m' );

		if ( $this->POST( 'submit_kuesioner' ) ) {

			if ( $this->session->userdata( 'id_pengguna' ) && $this->session->userdata( 'hak_akses' ) ) {
				
				foreach ( $this->data['pertanyaan'] as $pertanyaan ) {

					$check_jawaban_pengguna = $this->kuesioner_jawaban_pengguna_m->get_row([
						'id_pengguna'	=> $this->session->userdata( 'id_pengguna' ),
						'id_pertanyaan'	=> $pertanyaan->id_pertanyaan
					]);

					if ( $check_jawaban_pengguna ) {

						$this->kuesioner_jawaban_pengguna_m->update($check_jawaban_pengguna->id_jawaban_pengguna, [ 
							'id_jawaban'	=> $this->POST( 'jawaban-' . $pertanyaan->id_pertanyaan ),
							'updated_at'	=> date( 'Y-m-d H:i:s' ) 
						]);

					} else {

						$this->kuesioner_jawaban_pengguna_m->insert([
							'id_pengguna'			=> $this->session->userdata( 'id_pengguna' ),
							'id_pertanyaan'			=> $pertanyaan->id_pertanyaan,
							'id_jawaban'			=> $this->POST( 'jawaban-' . $pertanyaan->id_pertanyaan ),
							'id_jawaban_pengguna'	=> $this->__generate_random_id()
						]);					

					}

				}

				$this->flashmsg( '<i class="fa fa-check"></i> Terima kasih atas partisipasi anda dalam menjawab kuesioner' );

			} else {

				$this->flashmsg( 'Anda harus login terlebih dahulu <a href="' . base_url( 'auth' ) . '">disini</a> sebelum memberikan komentar', 'warning' );

			}
			
			redirect( 'wisata/detail/' . $this->data['kuesioner']->id_wisata );
			exit;

		}

		$this->load->model( 'kuesioner_pertanyaan_kategori_m' );
		$this->data['kategori']	= $this->kuesioner_pertanyaan_kategori_m->get();
		$this->data['title']	= 'Kuesioner';
		$this->data['content']	= 'wisata/wisata_kuesioner';
		$this->template( $this->data, 'wisata' );

	}

	public function list_event() {

		$this->load->model( 'event_m' );
		$this->data['list_event'] 	= $this->event_m->get_by_order( 'created_at', 'DESC' );
		$this->data['title']		= 'List Event';
		$this->data['content']		= 'wisata/event_list';
		$this->template( $this->data, 'wisata' );

	}

	public function detail_event() {

		$this->data['id_event']		= $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_event'] ) );

		$this->load->model( 'event_m' );
		$this->data['event']		= $this->event_m->get_row([ 'id_event' => $this->data['id_event'] ]);
		$this->check_allowance( !$this->data['event'], [ 'Data event tidak ditemukan', 'danger' ] );

		$this->data['foto']			= json_decode( $this->data['event']->foto );
		$this->data['title']		= $this->data['event']->nama_event;
		$this->data['content']		= 'wisata/event_detail';
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