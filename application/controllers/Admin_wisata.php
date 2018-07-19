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

		$this->data['foto']			= json_decode($this->data['wisata']->foto);

		if ( $this->POST( 'edit' ) ) {

			for ($i = 0; $i < $this->POST('num_img'); $i++)
			{
				if (isset($_FILES['berkas' . ($i + 1)]))
				{
					if (!empty($_FILES['berkas' . ($i + 1)]['name']))
					{
						@unlink(realpath(FCPATH . '/assets/img/wisata/' . $this->data['foto'][$i]));
						array_splice($this->data['foto'], $i, 1);
						$img_name = $this->data['id_wisata'] . '_' . pathinfo( $_FILES[ 'berkas' . ($i + 1) ]['name'], PATHINFO_FILENAME );
						$this->upload( $img_name, '/assets/img/wisata', 'berkas' . ($i + 1) );
						$this->data['foto'] []= $img_name . '.jpg';
					}
				}
				else
				{
					if ($i < count($this->data['foto']))
					{
						@unlink(realpath(FCPATH . '/assets/img/wisata/' . $this->data['foto'][$i]));
						array_splice($this->data['foto'], $i, 1);
					}
				}
			}


			$this->data['wisata']	= [
				'nama_wisata'	=> $this->POST( 'nama_wisata' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'foto'			=> json_encode( $this->data['foto'] ),
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
			
			redirect( 'admin-wisata/data-event' );
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

		$this->config->load( 'app' );
		$this->data['GOOGLE_MAPS_API_KEY'] = $this->config->item( 'GOOGLE_MAPS_API_KEY' );

		$this->load->model( 'event_m' );

		$this->data['event']		= $this->event_m->get_row([ 'id_event' => $this->data['id_event'] ]);
		$this->check_allowance( !isset( $this->data['event'] ), [ '<i class="fa fa-warning"></i> Data not found', 'danger' ] );
		

		if ( $this->POST( 'edit' ) ) {

			$num_img 		= $this->POST( 'num_img' );
			$deleted_photos	= $this->POST( 'deleted_photos' );
			$photos 		= json_decode( $this->data['event']->foto );

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


			$this->data['event']	= [
				'nama_event'	=> $this->POST( 'nama_event' ),
				'deskripsi'		=> $this->POST( 'deskripsi' ),
				'foto'			=> json_encode( $photos )
			];

			$this->event_m->update( $this->data['id_event'], $this->data['event'] );
			$this->upload( $this->data['id_event'], '/assets/img/wisata', 'berkas' );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil di-edit' );
			redirect( 'admin-wisata/edit-event/'. $this->data['id_event'] );
			exit;

		}

		
		$this->data['title']			= 'Edit Event';
		$this->data['content']			= 'admin_wisata/event_edit';
		$this->template( $this->data, 'admin_wisata' );

	}


	public function pertanyaan_kuesioner() {

		$this->load->model( 'wisata_m' );
		$this->data['id_wisata'] = $this->wisata_m->get_row([ 'id_admin' => $this->session->userdata( 'id_pengguna' ) ])->id_wisata;
		$this->check_allowance( !isset( $this->data['id_wisata'] ) );

		$this->load->model( 'pertanyaan_kuesioner_m' );
		$this->data['action'] 	= $this->uri->segment( 4 );
		if ( isset( $this->data['action'] ) && $this->data['action'] == 'delete' ) {

			$this->data['id_pertanyaan']	= $this->uri->segment( 3 );
			$this->pertanyaan_kuesioner_m->delete( $this->data['id_pertanyaan'] );
			$this->flashmsg( '<i class="fa fa-check"></i> Data berhasil dihapus' );
			redirect( 'admin_wisata/pertanyaan-kuesioner' );
			exit;

		}
				
		$this->load->model( 'kuesioner_m' );
		$this->data['kuesioner']	= $this->kuesioner_m->get_row([ 'id_wisata' => $this->data['id_wisata'] ]);
		$this->data['id_kuesioner'] = $this->data['kuesioner']->id_kuesioner;
		$this->check_allowance( !isset( $this->data['kuesioner'] ), [ 'Data not found', 'danger' ] );

		$this->load->model( 'kuesioner_jawaban_pengguna_m' );
		$this->data['overall_score'] = $this->kuesioner_jawaban_pengguna_m->get_overall_score( $this->data['id_kuesioner'] );

		$this->load->model( 'kuesioner_pertanyaan_m' );
		$this->data['pertanyaan'] = $this->kuesioner_pertanyaan_m->get([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);
		$this->load->model( 'kuesioner_pertanyaan_kategori_m' );
		$this->data['kategori'] = $this->kuesioner_pertanyaan_kategori_m->get();

		$this->data['title']	= 'Pertanyaan Kuesioner';
		$this->data['content']	= 'admin_wisata/kuesioner_pertanyaan_data';
		$this->template( $this->data, 'admin_wisata' );

	}

	public function tambah_pertanyaan_kuesioner() {

		$this->data['id_kuesioner'] = $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_kuesioner'] ) );

		$this->load->model( 'kuesioner_m' );
		$this->load->model( 'kuesioner_pertanyaan_kategori_m' );

		// if button with name=submit is clicked
		if ( $this->POST( 'submit' ) ) {

			$this->load->model( 'kuesioner_pertanyaan_m' );
			$this->load->model( 'kuesioner_jawaban_m' );
			
			// encapsulate question to be inserted
			$this->data['pertanyaan']	= [
				'pertanyaan'	=> $this->POST( 'pertanyaan' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
				'id_kuesioner'	=> $this->data['id_kuesioner'],
				'id_pertanyaan'	=> $this->__generate_random_id()
			];

			// insert question to kuesioner_pertanyaan table
			$this->kuesioner_pertanyaan_m->insert( $this->data['pertanyaan'] );

			// get last inserted primary key id
			$id_pertanyaan = $this->db->insert_id();

			// get jawaban and nilai data which passed as an array
			$jawaban 	= $this->POST( 'jawaban' );
			$nilai		= $this->POST( 'nilai' );

			// insert jawaban and nilai one by one
			for ( $i = 0; $i < count( $jawaban ) && $i < count( $nilai ); $i++ ) {

				$this->kuesioner_jawaban_m->insert([
					'id_pertanyaan'	=> $id_pertanyaan,
					'jawaban'		=> $jawaban[$i],
					'nilai'			=> $nilai[$i],
					'id_jawaban'	=> $this->__generate_random_id()
				]);

			}

			$this->flashmsg( '<i class="fa fa-check"></i> Pertanyaan kuesioner berhasil ditambahkan' );
			redirect( 'admin_wisata/pertanyaan-kuesioner/' . $this->data['id_kuesioner'] );
			exit;

		}

		$this->data['kategori']		= $this->kuesioner_pertanyaan_kategori_m->get();
		$this->data['kuesioner'] 	= $this->kuesioner_m->get_row([ 'id_kuesioner' => $this->data['id_kuesioner'] ]);
		$this->data['title']		= 'Tambah Pertanyaan ' . $this->data['kuesioner']->nama_kuesioner;
		$this->data['content']		= 'admin_wisata/kuesioner_pertanyaan_tambah';
		$this->template( $this->data, 'admin_wisata' );
	}

	public function edit_pertanyaan_kuesioner() {

		// irsyad
		$this->data['id_pertanyaan'] = $this->uri->segment( 3 );
		$this->check_allowance( !isset( $this->data['id_pertanyaan'] ) );

		$this->load->model( 'kuesioner_pertanyaan_kategori_m' );
		$this->load->model( 'kuesioner_pertanyaan_m' );
		$this->load->model( 'kuesioner_m' );
		$this->load->model( 'kuesioner_jawaban_m' );

		// if button with name=edit is clicked
		if ( $this->POST( 'edit' ) ) {
			
			// encapsulate question to be inserted
			$this->data['pertanyaan']	= [
				'pertanyaan'	=> $this->POST( 'pertanyaan' ),
				'id_kategori'	=> $this->POST( 'id_kategori' ),
			];

			// update question to kuesioner_pertanyaan table
			$this->kuesioner_pertanyaan_m->update( $this->data['id_pertanyaan'] , $this->data['pertanyaan'] );

			$this->flashmsg( '<i class="fa fa-check"></i> Pertanyaan kuesioner berhasil di edit' );
			redirect( 'admin_wisata/edit-pertanyaan-kuesioner/' . $this->data['id_pertanyaan'] );
			exit;

		}

		$this->data['kategori']		= $this->kuesioner_pertanyaan_kategori_m->get();
		$this->data['pertanyaan'] 	= $this->kuesioner_pertanyaan_m->get_row([ 'id_pertanyaan' => $this->data['id_pertanyaan'] ]);
		$this->data['kuesioner']	= $this->kuesioner_m->get_row([ 'id_kuesioner' => $this->data['pertanyaan']->id_kuesioner]);
		$this->data['jawaban'] 		= $this->kuesioner_jawaban_m->get([ 'id_pertanyaan' => $this->data['id_pertanyaan'] ]);
		$this->data['title']		= 'Edit Pertanyaan ' . $this->data['kuesioner']->nama_kuesioner;
		$this->data['content']		= 'admin_wisata/kuesioner_pertanyaan_edit';
		$this->template( $this->data, 'admin_wisata' );
	}

	public function rating_komentar()
	{
		$this->load->model('wisata_m');
		$this->data['wisata']		= $this->wisata_m->get_row([ 'id_admin' => $this->data['id_pengguna'] ]);
		$this->data['id_wisata']	= $this->data['wisata']->id_wisata;
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
		$this->data['data']			= $this->wisata_m->get_komentar_rating($this->data['id_wisata']);
		$this->data['title']		= 'Detail Wisata';
		$this->data['content']		= 'admin_wisata/rating_komentar';
		$this->template($this->data, 'admin_wisata');
	}

}