	<style type="text/css">
		ol > li {
		    list-style: decimal;
		}

		ul > li {
			font-size: 15px;
		}
	</style>
	<section class="bg2-pattern p-t-116 p-b-110 p-l-15 p-r-15">
		<div class="container" style="margin-top: 30px;">
			<h3 class="t-center m-t-2" style="margin-bottom: 25px;">
				<?= $kuesioner->nama_kuesioner ?>
			</h3>
			<?= form_open( 'wisata/kuesioner/' . $id_kuesioner, [ 'id' => 'example-basic' ] ) ?>
				<input type="hidden" name="submit_kuesioner" value="submit">
			    <?php foreach ( $kategori as $row ): ?>
				    <h3><?= $row->kategori ?></h3>
				    <section>
				    	<?php  
				    		$pertanyaan = $this->kuesioner_pertanyaan_m->get([ 'id_kuesioner' => $id_kuesioner, 'id_kategori' => $row->id_kategori ]);
				    		if ( count( $pertanyaan ) > 0 ):
				    	?>
				    		<?php foreach ( $pertanyaan as $p ): ?>
					    	<div><?= $p->pertanyaan ?></div>
							<br>
							<div class="row">
								<div class="col-md-12">
									<?php  
										$jawaban = $this->kuesioner_jawaban_m->get([ 'id_pertanyaan' => $p->id_pertanyaan ]);
										foreach ( $jawaban as $jwb ):
									?>
										<div class="radio i-checks">
											<label>
												<input type="radio" name="jawaban-<?= $p->id_pertanyaan ?>" value="<?= $jwb->id_jawaban ?>"><i></i> <?= $jwb->jawaban ?>
											</label>
										</div>
									<?php endforeach; ?>	
								</div>
							</div>
							<hr>
							<?php endforeach; ?>
				    	<?php else: ?>
				        <p>Kategori ini tidak memiliki pertanyaan</p>
				    	<?php endif; ?>
				    </section>
				<?php endforeach; ?>
			<?= form_close() ?>
		</div>
	</section>

	<style type="text/css">
		@import url("//www.jquery-steps.com/Content/examples.css");
	</style>
	<link rel="stylesheet" type="text/css" href="<?= base_url( 'assets/iCheck/skins/square/custom.css' ) ?>">
	<script type="text/javascript" src="<?= base_url( 'assets/jquery.steps/jquery.steps.min.js' ) ?>"></script>
	<script type="text/javascript" src="<?= base_url( 'assets/iCheck/icheck.min.js' ) ?>"></script>
	<script type="text/javascript">
		$( document ).ready(function() {
			$("#example-basic").steps({
			    headerTag: "h3",
			    bodyTag: "section",
			    transitionEffect: "slideLeft",
			    autoFocus: true,
			    onFinished: function( event, currentIndex ) {
			    	$( '#example-basic' ).submit();
			    }
			});
			$( '.i-checks' ).iCheck({
				checkboxClass: 'icheckbox_square-green',
            	radioClass: 'iradio_square-green',
			});
		});
	</script>
