	<style type="text/css">
		ol > li {
		    list-style: decimal;
		}

		ul > li {
			font-size: 15px;
		}
	</style>
	<section class="bg2-pattern p-t-116 p-b-110 t-center p-l-15 p-r-15">
		<div class="container" style="margin-top: 30px;">
			<h3 class="t-center m-t-2" style="margin-bottom: 25px;">
				<?= $kuesioner->nama_kuesioner ?>
			</h3>
			<?= form_open( 'wisata/kuesioner/' . $id_kuesioner ) ?>
			<?php $i = 0; foreach ( $pertanyaan as $row ): ?>
			<div class="row">
				<div class="col-md-7">
					<p><?= ++$i . '. ' . $row->pertanyaan ?></p>
					<div class="row">
						<div class="col-md-12">
							<?php  
								$jawaban = $this->kuesioner_jawaban_m->get([ 'id_pertanyaan' => $row->id_pertanyaan ]);
								foreach ( $jawaban as $jwb ):
							?>
								<p>
									<input type="radio" name="jawaban-<?= $row->id_pertanyaan ?>" value="<?= $jwb->id_jawaban ?>"> <?= $jwb->jawaban ?>
								</p>
							<?php endforeach; ?>	
						</div>
					</div>
				</div>
			</div>
			<hr>
			<?php endforeach; ?>
			<input type="submit" class="btn btn-success" name="submit_kuesioner" value="Submit Kuesioner">
			<?= form_close() ?>
		</div>
	</section>

