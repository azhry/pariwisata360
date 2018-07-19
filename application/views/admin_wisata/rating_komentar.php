        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <style type="text/css">
            .star-rating {
              line-height:32px;
              font-size:1.25em;
            }

            .star-rating .fa-star{
                color: #ec1d25;
            }
        </style>
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
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Komentar</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach ($data as $row): ?>
                                        <tr>
                                            <td><?= ++$i ?></td>
                                            <td><?= $row->nama ?></td>
                                            <td><?= $row->komentar ?></td>
                                            <td>
                                                <?php if ($row->rating != NULL): ?>
                                                <div class="star-rating">
                                                    <span class="fa fa-star-o" data-rating="1"></span>
                                                    <span class="fa fa-star-o" data-rating="2"></span>
                                                    <span class="fa fa-star-o" data-rating="3"></span>
                                                    <span class="fa fa-star-o" data-rating="4"></span>
                                                    <span class="fa fa-star-o" data-rating="5"></span>
                                                    <input type="hidden" name="rating" class="rating-value" value="<?= $row->rating ?>"> <?= $row->rating ?>
                                                </div>
                                                <?php else: ?>
                                                    Belum ada rating
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
                $('.star-rating').each(function(i, dom) {
                    let star_rating = $(dom).find('.fa');
                    star_rating.each(function() {
                        if (parseInt(star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                            return $(this).removeClass('fa-star-o').addClass('fa-star');
                        } else {
                            return $(this).removeClass('fa-star').addClass('fa-star-o');
                        }
                    });
                });
            });
        </script>