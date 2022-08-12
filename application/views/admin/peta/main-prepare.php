<?php $profile = check_profile(); ?>
<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.Default.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

<div class="main-content">

    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $title; ?></h4>

                    <div class="page-title-right">
                        <?= $breadcrumbs; ?>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <?php $this->view('session'); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-table"></i> Keterangan
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-map-marked-alt"></i> Mapping
                                    </div>
                                    <div class="card-body">
                                        <div id='map' style='width: 100%; height:500px;'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>


<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js'></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script>
    $(document).ready(function() {
        L.mapbox.accessToken = 'pk.eyJ1IjoiYmltYWVnYTEyIiwiYSI6ImNrcXFxbDd6cTAza3oyd215dDNvNWJ2d20ifQ.obyTqre9zTXcmd5XXWvw1A';

        var tiles = L.tileLayer(
                "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    maxZoom: 18,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                }
            ),
            latlng = new L.LatLng(50.5, 30.51);

        var map = new L.Map("map", {
            center: latlng,
            zoom: 15,
            layers: [tiles]
        });

        // full screen
        L.control.fullscreen().addTo(map).setPosition('topright');;

        // geocoding
        map.addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11')).addControl(L.mapbox.geocoderControl('mapbox.places', {
            autocomplete: true
        }));


        var markers = new L.MarkerClusterGroup();
        var markersList = [];

        function populate() {
            for (var i = 0; i < 100; i++) {
                var m = new L.Marker(getRandomLatLng(map));
                markersList.push(m);
                markers.addLayer(m);
            }
            return false;
        }

        function populateRandomVector() {
            for (var i = 0, latlngs = [], len = 20; i < len; i++) {
                latlngs.push(getRandomLatLng(map));
            }
            var path = new L.Polyline(latlngs);
            map.addLayer(path);
        }

        function getRandomLatLng(map) {
            var bounds = map.getBounds(),
                southWest = bounds.getSouthWest(),
                northEast = bounds.getNorthEast(),
                lngSpan = northEast.lng - southWest.lng,
                latSpan = northEast.lat - southWest.lat;

            return new L.LatLng(
                southWest.lat + latSpan * Math.random(),
                southWest.lng + lngSpan * Math.random()
            );
        }

        markers.on("clusterclick", function(a) {
            alert("cluster " + a.layer.getAllChildMarkers().length);
        });
        markers.on("click", function(a) {
            alert("marker " + a.layer);
        });

        populate();
        map.addLayer(markers);

        L.DomUtil.get("populate").onclick = function() {
            var bounds = map.getBounds(),
                southWest = bounds.getSouthWest(),
                northEast = bounds.getNorthEast(),
                lngSpan = northEast.lng - southWest.lng,
                latSpan = northEast.lat - southWest.lat;
            var m = new L.Marker(
                new L.LatLng(
                    southWest.lat + latSpan * 0.5,
                    southWest.lng + lngSpan * 0.5
                )
            );
            markersList.push(m);
            markers.addLayer(m);
        };
        L.DomUtil.get("remove").onclick = function() {
            markers.removeLayer(markersList.pop());
        };



    })
</script>