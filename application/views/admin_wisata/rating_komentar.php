        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <script type="text/javascript" src="<?= base_url( 'assets/chartjs/Chart.min.js' ) ?>"></script>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?= $wisata->nama_wisata ?></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li class="active"><?= $wisata->nama_wisata ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title"><?= $wisata->nama_wisata ?></h3>
                            <style type="text/css">
                                .star-rating {
                                  line-height:32px;
                                  font-size:1.25em;
                                }

                                .star-rating .fa-star{
                                    color: #ec1d25;
                                }
                            </style>
                            <div class="container">
                                <div class="star-rating" id="display-rating">
                                    <span class="fa fa-star-o" data-rating="1"></span>
                                    <span class="fa fa-star-o" data-rating="2"></span>
                                    <span class="fa fa-star-o" data-rating="3"></span>
                                    <span class="fa fa-star-o" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                    <input type="hidden" name="rating" id="rating-value" class="rating-value" value="<?= isset( $rating ) ? $rating->rating : 0 ?>"> <?= isset( $rating ) ? $rating->rating : 0 ?>
                                </div>
                            </div>
                            <?php foreach ($kuesioner as $k): ?>
                            <?php  
                                $overall_score = $this->kuesioner_jawaban_pengguna_m->get_overall_score( $k->id_kuesioner );
                            ?>
                            <div class="container">
                                <h4><?= $k->nama_kuesioner ?></h4>
                                <canvas id="grafik-<?= $k->id_kuesioner ?>"></canvas>
                                <script type="text/javascript">
                                    var config = {
                                        type: 'bar',
                                        data: {
                                            labels: [
                                                <?php foreach ( $kategori as $row ): ?>
                                                    "<?= $row->kategori ?>",
                                                <?php endforeach; ?>
                                            ],
                                            datasets: [{
                                                label: 'Rata-rata penilaian wisata per kategori',
                                                backgroundColor: '#7460ee',
                                                borderColor: '#7460ee',
                                                fill: false,
                                                data: [
                                                    <?php foreach ( $kategori as $row ): ?>
                                                        <?php  
                                                            $score = 0;
                                                            foreach ( $overall_score as $overall ) {

                                                                if ( $row->id_kategori == $overall->id_kategori ) {
                                                                    $score = $overall->overall;
                                                                }
                                                            
                                                            }

                                                        ?>
                                                        <?= $score ?>,
                                                    <?php endforeach; ?>
                                                ]
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                yAxes: [{
                                                    display: true,
                                                    ticks: {
                                                        beginAtZero: true,
                                                        max: 5
                                                    }
                                                }]
                                            }
                                        }
                                    };
                                    var ctx = document.getElementById( 'grafik-<?= $k->id_kuesioner ?>' ).getContext( '2d' );
                                    new Chart( ctx, config );
                                </script>
                            </div>
                            <?php endforeach; ?>
                            <div class="container">
                                <h4>Komentar</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="15">No.</th>
                                            <th>Komentar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach ($komentar as $row): ?>
                                            <tr>
                                                <td><?= ++$i ?></td>
                                                <td><?= $row->komentar ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Ample Admin brought to you by wrappixel.com </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->

        <script type="text/javascript">
            $(document).ready(function() {
                var $star_rating = $('#display-rating .fa');

                var SetRatingStar = function() {
                    return $star_rating.each(function() {
                        if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                            return $(this).removeClass('fa-star-o').addClass('fa-star');
                        } else {
                            return $(this).removeClass('fa-star').addClass('fa-star-o');
                        }
                    });
                };

                $star_rating.on('click', function() {
                    $star_rating.siblings('input.rating-value').val($(this).data('rating'));
                    return SetRatingStar();
                });

                SetRatingStar();
            });
        </script>