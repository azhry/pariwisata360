        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?= $title ?></h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?= base_url( 'admin/index' ) ?>">Dashboard</a></li>
                            <li><a href="<?= base_url( 'admin/data-wisata' ) ?>">Data Wisata</a></li>
                            <li class="active"><?= $title ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title"><?= $title ?></h3> 
                            
                            <?= $this->session->flashdata( 'msg' ) ?>
                            <?= form_open_multipart( 'admin/tambah-wisata' ) ?>

                            <div class="form-group">
                                <label for="nama_wisata">Nama Wisata</label>
                                <input type="text" name="nama_wisata" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="kategori_wisata">Kategori Wisata</label>
                                <select class="form-control" name="id_kategori">
                                    <option>Pilih Kategori</option>
                                    <?php foreach ( $kategori as $row ): ?>
                                        <option value="<?= $row->id_kategori ?>"><?= $row->nama_kategori ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" required></textarea>
                            </div>

                            <input type="hidden" name="num_img" value="1" id="num-img">
                            <button type="button" id="tambah-foto-btn" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Foto</button>
                            <div id="foto-container">
                                <div class="form-group">
                                    <label for="foto">Foto 1</label>
                                    <input type="file" name="berkas1" accept="image/*" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="koordinat">Pilih Koordinat</label>
                                <div id="map" style="width: 100%; height: 300px;"></div>
                            </div>

                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input id="latitude" type="number" step="any" name="latitude" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input id="longitude" type="number" step="any" name="longitude" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="admin_wisata">Admin Wisata</label>
                                <select class="form-control" name="id_admin">
                                    <?php foreach ( $admin_wisata as $admin ): ?>
                                        <option value="<?= $admin->id_pengguna ?>"><?= $admin->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <input type="submit" name="submit" value="Tambah" class="btn btn-primary">

                            <?= form_close() ?>

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
            var map;
            function initMap() {

                let plgLat = -2.990934;
                let plgLng = 104.756554;
                let plgPos = new google.maps.LatLng( plgLat, plgLng );
                map = new google.maps.Map(document.getElementById( 'map' ), {
                    center: plgPos,
                    zoom: 12
                });

                document.getElementById( 'latitude' ).value     = plgLat;
                document.getElementById( 'longitude' ).value    = plgLng;

                let plgMarker = new google.maps.Marker({
                    position: plgPos,
                    map: map
                });

                google.maps.event.addListener(map, 'click', function( event ) {

                    let latLng = new google.maps.LatLng( event.latLng.lat(), event.latLng.lng() );
                    plgMarker.setPosition( latLng );
                    document.getElementById( 'latitude' ).value     = event.latLng.lat();
                    document.getElementById( 'longitude' ).value    = event.latLng.lng();

                });

                google.maps.event.addListener(map, 'mousemove', function(event){
                    map.setOptions({draggableCursor: 'pointer'});
                });

                $( document ).ready(function() {
                    
                    $( '#latitude, #longitude' ).keypress(function() {
                        
                        let lat = $( '#latitude' ).val();
                        let lng = $( '#longitude' ).val();
                        
                        let latLng = new google.maps.LatLng( lat, lng );
                        plgMarker.setPosition( latLng );
                        map.setCenter( latLng );

                    });

                });

            }
        </script>

        <script type="text/javascript">
            $( document ).ready(function() {

                var idx = 1;

                $( '#tambah-foto-btn' ).on('click', function() {

                    $( '#foto-container' ).append('<div class="form-group">' +
                        '<label for="foto">Foto ' + (++idx) + '</label>' +
                        '<input type="file" name="berkas' + idx + '" accept="image/*" class="form-control" required>' +
                    '</div>');

                    $( '#num-img' ).val( idx );

                });

            });
        </script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $GOOGLE_MAPS_API_KEY ?>&callback=initMap"></script>