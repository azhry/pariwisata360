	<style type="text/css">
		ol > li {
		    list-style: decimal;
		}

		ul > li {
			font-size: 15px;
		}
	</style>
	<section class="bg2-pattern p-t-116 p-b-110 t-center p-l-15 p-r-15">
		<div class="container">
			<h3 class="tit5 t-center m-t-2">
				Kuesioner Wisata
			</h3>
			<ol class="pull-left">
				<?php foreach ( $pertanyaan as $row ): ?>
				<li>
					<p><?= $row->pertanyaan ?></p>
					<ul>
						<?php  
							$jawaban = $this->kuesioner_jawaban_m->get([ 'id_pertanyaan' => $row->id_pertanyaan ]);
							foreach ( $jawaban as $jwb ):
						?>
							<li><?= $jwb->jawaban ?></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

