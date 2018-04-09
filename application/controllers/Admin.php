<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin extends MY_Controller {

	public function __construct() {

		parent::__construct();
		$this->data['id_pengguna']	= $this->session->userdata( 'id_pengguna' );
		if ( !isset( $this->data['id_pengguna'] ) ) {

			$this->session->sess_destroy();
			$this->flashmsg( 'Anda harus login terlebih dahulu', 'warning' );
			redirect( 'login' );
			exit;

		}

		$this->data['role']	= $this->session->userdata( 'role' );
		if ( $this->data['role'] != 'admin' ) {

			$this->session->sess_destroy();
			$this->flashmsg( 'Anda harus login sebagai admin', 'warning' );
			redirect( 'login' );
			exit;

		}

		$this->load->model( 'pengguna_m' );
		$this->load->model( 'admin_m' );
		$this->data['admin'] = $this->pengguna_m->get_admin( [ 'admin.id_pengguna' => $this->data['id_pengguna'] ] );
		$this->data['admin']->lingkup = $this->admin_m->get_lingkup_admin( $this->data['admin']->nik );

		$this->load->model( 'fakultas_m' );
		$this->data['daftar_fakultas']		= $this->fakultas_m->get();

		if ( $this->data['admin']->id_lingkup == 1 ) { // lingkup fakultas

			$this->load->model( 'jurusan_m' );
			$this->data['daftar_jurusan']	= $this->jurusan_m->get([ 'id_fakultas' => $this->data['admin']->lingkup['id_fakultas'] ]);

		}

	}

	public function index() {

		$this->data['title'] 	= 'Dashboard | ' . $this->title;
		$this->data['content']	= 'admin/dashboard';
		$this->template( $this->data );
	
	}

	public function daftar_pertanyaan() {

		$this->load->model( 'pertanyaan_m' );
		if ( $this->GET( 'delete', true ) ) {

			$this->pertanyaan_m->delete( $this->GET( 'id_pertanyaan', true ) );
			$this->flashmsg( 'Pertanyaan berhasil dihapus' );
			redirect( 'admin/daftar-pertanyaan' );
			exit;

		}

		$this->data['pertanyaan'] = [];

		if ( $this->data['admin']->id_lingkup == 6 ) { // lingkup universitas

			$this->data['pertanyaan']	= $this->pertanyaan_m->get_pertanyaan();

		} else if ( $this->data['admin']->id_lingkup == 1 ) { // lingkup fakultas

			$this->load->model( 'pertanyaan_fakultas_m' );
			$this->data['pertanyaan']	= $this->pertanyaan_fakultas_m->get_list_pertanyaan( $this->data['admin']->lingkup['id_fakultas'] );

		} else if ( $this->data['admin']->id_lingkup == 2 ) { // lingkup jurusan

			$this->load->model( 'pertanyaan_jurusan_m' );
			$this->data['pertanyaan']	= $this->pertanyaan_jurusan_m->get_list_pertanyaan( $this->data['admin']->lingkup['id_jurusan'] );

		}
		$this->data['title']		= 'Daftar Pertanyaan | ' . $this->title;
		$this->data['content']		= 'admin/daftar_pertanyaan';
		$this->data['page_script']	= 'admin/daftar_pertanyaan_script';
		$this->template( $this->data );

	}

	public function buat_pertanyaan() {

		$this->load->model( 'pertanyaan_m' );
		$this->load->model( 'kategori_pertanyaan_m' );
		$this->load->model( 'pilihan_jawaban_m' );

		if ( $this->POST( 'submit' ) ) {

			if ( $this->pertanyaan_m->required_input([ 'pertanyaan', 'id_kategori', 'jawaban[]', 'skor[]' ]) ) {

				$jawaban 	= $this->POST( 'jawaban' );
				if ( count( $jawaban ) < 2 ) {

					$this->flashmsg( 'Anda harus membuat lebih dari satu pilihan jawaban', 'danger' );
					redirect( 'admin/buat-pertanyaan' );
					exit;

				}

				$skor		= $this->POST( 'skor' );
				$this->data['pertanyaan'] = [
					'id_pertanyaan'		=> $this->generate_id(),
					'id_kategori'		=> $this->POST( 'id_kategori' ),
					'pertanyaan'		=> $this->POST( 'pertanyaan' ),
					'id_lingkup'		=> $this->data['admin']->id_lingkup
				];

				$this->pertanyaan_m->insert( $this->data['pertanyaan'] );
				$id_pertanyaan = $this->db->insert_id();

				for ( $i = 0; $i < count( $jawaban ); $i++ ) {

					if ( !empty( $jawaban[$i] ) && !empty( $skor[$i] ) ) {

						$this->pilihan_jawaban_m->insert([
							'id_pertanyaan'	=> $id_pertanyaan,
							'jawaban'		=> $jawaban[$i],
							'skor'			=> $skor[$i]
						]);

					}

				}

				if ( $this->data['admin']->lingkup != NULL ) {

					if ( $this->data['admin']->lingkup['lingkup'] == 'Fakultas' ) {

						$this->load->model( 'pertanyaan_fakultas_m' );
						$this->pertanyaan_fakultas_m->insert([
							'id_pertanyaan'	=> $id_pertanyaan,
							'id_fakultas'	=> $this->data['admin']->lingkup['id_fakultas']
						]);

					} else if ( $this->data['admin']->lingkup['lingkup'] == 'Jurusan' ) {

						$this->load->model( 'pertanyaan_jurusan_m' );
						$this->pertanyaan_jurusan_m->insert([
							'id_pertanyaan'	=> $id_pertanyaan,
							'id_jurusan'	=> $this->data['admin']->lingkup['id_jurusan']
						]);

					}
					
				}
				$this->flashmsg( 'Pertanyaan berhasil dibuat' );
				redirect( 'admin/daftar-pertanyaan' );

			} else {

				$this->flashmsg( 'Data yang anda masukkan belum lengkap', 'danger' );
				redirect( 'admin/buat-pertanyaan' );

			}
			exit;

		}

		$this->data['kategori']		= $this->kategori_pertanyaan_m->get();
		$this->data['title']		= 'Buat Pertanyaan | ' . $this->title;
		$this->data['content']		= 'admin/buat_pertanyaan';
		$this->data['page_script']	= 'admin/buat_pertanyaan_script';
		$this->template( $this->data );	

	}

	public function sunting_pertanyaan() {

		$this->data['id_pertanyaan']	= $this->uri->segment( 3 );
		if ( !isset( $this->data['id_pertanyaan'] ) ) {

			$this->flashmsg( 'Required parameter is missing', 'danger' );
			redirect( 'admin/daftar-pertanyaan' );
			exit;

		}

		$this->load->model( 'pertanyaan_m' );
		$this->load->model( 'kategori_pertanyaan_m' );
		$this->load->model( 'pilihan_jawaban_m' );

		$this->data['pertanyaan']	= $this->pertanyaan_m->get_row([ 'id_pertanyaan' => $this->data['id_pertanyaan'] ]);
		if ( !isset( $this->data['id_pertanyaan'] ) ) {

			$this->flashmsg( 'Data not found', 'danger' );
			redirect( 'admin/daftar-pertanyaan' );
			exit;

		}

		if ( $this->POST( 'edit' ) ) {

			if ( $this->pertanyaan_m->required_input([ 'pertanyaan', 'id_kategori' ]) ) {

				$jawaban 	= $this->POST( 'jawaban' );
				if ( count( $jawaban ) < 2 ) {

					$this->flashmsg( 'Anda harus membuat lebih dari satu pilihan jawaban', 'danger' );
					redirect( 'admin/sunting-pertanyaan/' . $this->data['id_pertanyaan'] );
					exit;

				}

				$skor		= $this->POST( 'skor' );
				$this->data['pertanyaan'] = [
					'id_kategori'		=> $this->POST( 'id_kategori' ),
					'pertanyaan'		=> $this->POST( 'pertanyaan' ),
					'id_lingkup'		=> $this->data['admin']->id_lingkup
				];

				$this->pertanyaan_m->update( $this->data['id_pertanyaan'], $this->data['pertanyaan'] );
				$id_pertanyaan 	= $this->data['id_pertanyaan'];
				$id_jawaban		= $this->POST( 'id_jawaban' );
				for ( $i = 0; $i < count( $id_jawaban ); $i++ ) {

					if ( !empty( $jawaban[$i] ) && !empty( $skor[$i] ) ) {

						$this->pilihan_jawaban_m->update($id_jawaban[$i], [
							'id_pertanyaan'	=> $id_pertanyaan,
							'jawaban'		=> $jawaban[$i],
							'skor'			=> $skor[$i]
						]);

					}

				}

				$deleted_id_jawaban = $this->POST( 'deleted_id_jawaban' );
				foreach ( $deleted_id_jawaban as $id_jawaban ) {

					$this->pilihan_jawaban_m->delete( $id_jawaban );

				}

				$jawaban_baru 	= $this->POST( 'jawaban_baru' );
				$skor_baru		= $this->POST( 'skor_baru' );
				for ( $i = 0; $i < count( $id_jawaban ); $i++ ) {

					if ( !empty( $jawaban_baru[$i] ) && !empty( $skor_baru[$i] ) ) {

						$this->pilihan_jawaban_m->insert([
							'id_pertanyaan'	=> $id_pertanyaan,
							'jawaban'		=> $jawaban_baru[$i],
							'skor'			=> $skor_baru[$i]
						]);

					}

				}
				
				$this->flashmsg( 'Pertanyaan berhasil disunting' );
				redirect( 'admin/sunting-pertanyaan/' . $this->data['id_pertanyaan'] );

			} else {

				$this->flashmsg( 'Data yang anda masukkan belum lengkap', 'danger' );
				redirect( 'admin/sunting-pertanyaan/' . $this->data['id_pertanyaan'] );

			}
			exit;

		}

		$this->load->model( 'kategori_pertanyaan_m' );
		$this->load->model( 'pilihan_jawaban_m' );

		$this->data['kategori']		= $this->kategori_pertanyaan_m->get();
		$this->data['jawaban']		= $this->pilihan_jawaban_m->get([ 'id_pertanyaan' => $this->data['id_pertanyaan'] ]);
		$this->data['title']		= 'Sunting Pertanyaan | ' . $this->title;
		$this->data['content']		= 'admin/sunting_pertanyaan';
		$this->data['page_script']	= 'admin/sunting_pertanyaan_script';
		$this->template( $this->data );

	}

	public function laporan_survei() {

		$this->load->model( 'pertanyaan_m' );
		$this->load->model( 'fakultas_m' );
		$this->load->model( 'pertanyaan_fakultas_m' );
		$this->load->model( 'jurusan_m' );
		$this->load->model( 'kategori_pertanyaan_m' );

		if ( $this->data['admin']->id_lingkup == 6 ) { // admin lingkup universitas

			$this->data['fakultas'] = $this->fakultas_m->get();

		}
		//  else if ( $this->data['admin']->id_lingkup == 1 ) { // admin lingkup fakultas

		// 	$this->data['jurusan']	= $this->jurusan_m->get();

		// } else if ( $this->data['admin']->id_lingkup == 2 ) { // admin lingkup jurusan

		// 	$this->data['jurusan']	= $this->jurusan_m->get_row([ 'id_jurusan' => $this->data['admin']->lingkup['id_jurusan'] ]);

		// }

		$this->data['kategori']		= $this->kategori_pertanyaan_m->get();
		$this->data['title']		= 'Laporan Survei | ' . $this->title;
		$this->data['content']		= 'admin/laporan_survei';
		$this->data['page_script']	= 'admin/laporan_survei_script';
		$this->template( $this->data );

	}

	public function laporan_fakultas() {

		if ( $this->data['admin']->lingkup['lingkup'] == 'Fakultas' ) {

			$this->data['id_fakultas']	= $this->data['admin']->lingkup['id_fakultas'];

		} else {

			$this->data['id_fakultas']	= $this->uri->segment( 3 );
		
		}
		$this->check_allowance( !isset( $this->data['id_fakultas'] ) );

		$this->data['fakultas']	= $this->fakultas_m->get_row([ 'id_fakultas' => $this->data['id_fakultas'] ]);
		$this->check_allowance( !isset( $this->data['fakultas'] ), [ 'Data not found', 'danger' ] );

		$this->load->model( 'pertanyaan_m' );
		$this->load->model( 'fakultas_m' );
		$this->load->model( 'pertanyaan_fakultas_m' );
		$this->load->model( 'jurusan_m' );
		$this->load->model( 'pertanyaan_jurusan_m' );
		$this->load->model( 'kategori_pertanyaan_m' );

		$this->data['jurusan']		= $this->jurusan_m->get([ 'id_fakultas' => $this->data['id_fakultas'] ]);
		$this->data['kategori']		= $this->kategori_pertanyaan_m->get();
		$this->data['title']		= 'Laporan Survei ' . $this->data['fakultas']->nama . ' | ' . $this->title;
		$this->data['content']		= 'admin/laporan_fakultas';
		$this->data['page_script']	= 'admin/laporan_fakultas_script';
		$this->template( $this->data );

	}

	public function laporan_jurusan() {

		if ( $this->data['admin']->lingkup['lingkup'] == 'Jurusan' ) {

			$this->data['id_jurusan']	= $this->data['admin']->lingkup['id_jurusan'];

		} else {

			$this->data['id_jurusan']	= $this->uri->segment( 3 );
		
		}
		$this->check_allowance( !isset( $this->data['id_jurusan'] ) );

		$this->load->model( 'jurusan_m' );
		$this->data['jurusan']	= $this->jurusan_m->get_row([ 'id_jurusan' => $this->data['id_jurusan'] ]);
		$this->check_allowance( !isset( $this->data['jurusan'] ), [ 'Data not found', 'danger' ] );

		$this->load->model( 'pertanyaan_m' );
		$this->load->model( 'fakultas_m' );
		$this->load->model( 'pertanyaan_fakultas_m' );
		$this->load->model( 'jurusan_m' );
		$this->load->model( 'pertanyaan_jurusan_m' );
		$this->load->model( 'kategori_pertanyaan_m' );

		$this->data['kategori']		= $this->kategori_pertanyaan_m->get();
		$this->data['title']		= 'Laporan Survei ' . $this->data['jurusan']->nama . ' | ' . $this->title;
		$this->data['content']		= 'admin/laporan_jurusan';
		$this->data['page_script']	= 'admin/laporan_jurusan_script';
		$this->template( $this->data );

	}





	public function daftar_survei() {

		$this->load->model( 'survei_m' );
		$this->data['daftar_survei']	= $this->survei_m->get_by_order( 'created_at', 'DESC' );
		$this->data['title']			= 'Daftar Survei | ' . $this->title;
		$this->data['content']			= 'admin/daftar_survei';
		$this->data['page_script']		= 'admin/daftar_survei_script';
		$this->template( $this->data );

	}

	public function tambah_survei() {

		$this->load->model( 'survei_m' );
		$this->load->model( 'jabatan_m' );
		$this->load->model( 'fakultas_m' );
		$this->load->model( 'jurusan_m' );

		$this->_ajax_response_get_lingkup();
		if ( $this->POST( 'submit' ) ) {

			if ( !$this->survei_m->required_input( [ 'judul', 'deskripsi', 'mulai', 'selesai' ] ) ) {

				$this->flashmsg( 'Required parameters are missing', 'danger' );
				redirect( 'admin/tambah-survei' );
				exit;

			}

			$this->load->model( 'lingkup_m' );
			$this->load->model( 'lingkup_survei_m' );

			$judul		= $this->POST( 'judul' );
			$deskripsi	= $this->POST( 'deskripsi' );
			$mulai		= $this->POST( 'mulai' );
			$selesai	= $this->POST( 'selesai' );
			$this->survei_m->insert( [
				'id_survei'	=> $this->generate_id(),
				'judul'		=> $judul,
				'deskripsi'	=> $deskripsi,
				'mulai'		=> $mulai,
				'selesai'	=> $selesai
			] );

			$id_survei	= $this->db->insert_id();
			$id_jabatan = $this->POST( 'jabatan' );
			if ( count( $id_jabatan ) > 0 ) {

				foreach ( $id_jabatan as $id ) {

					$jabatan = $this->jabatan_m->get_row( [ 'id_jabatan' => $id ] );
					if ( isset( $jabatan ) ) {

						$lingkup = $this->lingkup_m->get_row( [ 'nama' => $jabatan->nama_jabatan ] );
						if ( isset( $lingkup ) ) {

							$this->lingkup_survei_m->insert( [
								'id_survei'		=> $id_survei,
								'id_lingkup'	=> $lingkup->id_lingkup,
								'id'			=> $id
							] );

						}

					}

				}

			}

			$id_fakultas = $this->POST( 'fakultas' );
			if ( count( $id_fakultas ) > 0 ) {

				foreach ( $id_fakultas as $id ) {

					$lingkup = $this->lingkup_m->get_row( [ 'nama' => 'Fakultas' ] );
					if ( isset( $lingkup ) ) {

						$this->lingkup_survei_m->insert( [
							'id_survei'		=> $id_survei,
							'id_lingkup'	=> $lingkup->id_lingkup,
							'id'			=> $id
						] );

						$id_jurusan = $this->POST( 'jurusan_' . $id );
						if ( count( $id_jurusan ) > 0 ) {

							foreach ( $id_jurusan as $id_sub ) {

								$lingkup = $this->lingkup_m->get_row( [ 'nama' => 'Jurusan' ] );
								if ( isset( $lingkup ) ) {

									$this->lingkup_survei_m->insert( [
										'id_survei'		=> $id_survei,
										'id_lingkup'	=> $lingkup->id_lingkup,
										'id'			=> $id_sub
									] );

								}

							}

						}

					}

				}

			}

			redirect( 'admin/daftar-survei' );
			exit;

		}

		$this->data['jabatan']		= $this->jabatan_m->get();
		$this->data['fakultas']		= $this->fakultas_m->get();
		$this->data['jurusan']		= $this->jurusan_m->get();
		$this->data['title']		= 'Tambah Survei | ' . $this->title;
		$this->data['content']		= 'admin/tambah_survei';
		$this->data['page_script']	= 'admin/tambah_survei_script';
		$this->template( $this->data );

	}

	private function _ajax_response_get_lingkup() {

		$ajax_action = $this->POST( 'action_name' );

		if ( isset( $ajax_action ) && $ajax_action == 'get_lingkup' ) {

			$this->load->model( 'jurusan_m' );

			$html = '';
			$IDs = $this->POST( 'id' );
			if ( isset( $IDs['fakultas'] ) && count( $IDs['fakultas'] ) > 0 ) {

				foreach ( $IDs['fakultas'] as $id_fakultas ) {

					$jurusan = $this->jurusan_m->get( [ 'id_fakultas' => $id_fakultas ] );
					foreach ( $jurusan as $row ) {

						$html .= '<div class="i-checks">
							<label>
								<input type="checkbox" name="jurusan_' . $id_fakultas . '[]" value="' . $row->id_jurusan . '"><i></i>
								' . $row->nama . '
							</label>
						</div>';

					}

				}

			}

			echo $html;
			exit;

		}

	}

}