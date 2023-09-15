@extends('layouts.admin')

@push('css')
    <style>
        .themap {
            height: 850px !important;
            z-index: 999;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="page-title">{{ $title }}</h6>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="themap" class="themap" style="height: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('components.footer')
    </div>
@endsection

@push('js')
    <script defer
        src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ env('GMAP_API_KEY') }}&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-marker-clusterer/1.0.0/markerclusterer_compiled.js"></script>

    <script>
        var longitude = {{ env('LONG_DEFAULT') }};
        var latitude = {{ env('LAT_DEFAULT') }};
        $(document).ready(function() {

            var gmarkers1 = [];
            var markers1 = [];
            var infowindow = new google.maps.InfoWindow({
                content: ''
            });

            let data = {
                'user_id': '{{ auth()->user()->id }}',
            };

            /**
             * Function to init map
             */

            function initialize() {
                var center = new google.maps.LatLng(latitude, longitude);
                var mapOptions = {
                    zoom: 15,
                    center: {
                        lat: {{ env('LAT_DEFAULT') }},
                        lng: {{ env('LONG_DEFAULT') }}
                    },
                    zoomControl: true,
                    mapTypeId: google.maps.MapTypeId.HYBRID
                };

                map = new google.maps.Map(document.getElementById('themap'), mapOptions);
                $('.map-card').addClass('is-loading');
                $.ajax({
                    url: "{{ route('v1.tracking.get_tracking_odp') }}",
                    dataType: 'json',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response) {
                        $('.map-card').removeClass('is-loading');
                        markers1 = response.map(el => {
                            return {
                                "kode": el['kode'],
                                "keterangan": el['keterangan'],
                                "alamat": el['alamat'],
                                "latitude": parseFloat(el['latitude']),
                                "longitude": parseFloat(el['longitude']),
                                "power": el['power'],
                                "port": el['port'],
                                "jarak_pop": el['jarak_pop'],
                                "marker_icon": el['marker_icon'],
                                "doc": el['doc'],
                            }
                        });

                        for (i = 0; i < markers1.length; i++) {
                            addMarker(markers1[i]);
                        }
                        var markerCluster = new MarkerClusterer(map, gmarkers1, {
                            imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                        });
                    }
                })

                // Timeslot atau menampilkan hasil customer
                $.ajax({
                    url: "{{ route('v1.tracking.get_tracking_timeslot') }}",
                    dataType: 'json',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response) {
                        $('.map-card').removeClass('is-loading');
                        markers1 = response.map(el => {
                            return {
                                "customer_id": el['customer_id'],
                                "customer_name": el['customer_name'],
                                "customer_address": el['customer_address'],
                                "latitude": parseFloat(el['latitude']),
                                "longitude": parseFloat(el['longitude']),
                                "odp": el['odp'],
                                "ont": el['ont'],
                                "serial_number": el['serial_number'],
                                "cable_distance": el['cable_distance'],
                                "marker_icon": el['marker_icon'],
                                "doc": el['doc'],
                            }
                        });

                        for (i = 0; i < markers1.length; i++) {
                            addMarkerTimeslot(markers1[i]);
                        }
                        var markerCluster = new MarkerClusterer(map, gmarkers1, {
                            imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                        });
                    }
                })

            }

            /**
             * Function to add marker to map
             */

            function addMarker(marker) {
                var title = marker["kode"];
                var pos = new google.maps.LatLng(marker["latitude"], marker["longitude"]);

                var content = `<div class="keterangan">
                        <div style="color:black;font-size:16px;font-weight:bold;">${title}</div>
                        <p style="color:black;margin-bottom:2px;">Power: <span style="color:black"> ${marker.power} </span></p>
                        <p style="color:black;margin-bottom:2px;">Port: ${marker.port}</p>
                        <p style="color:black;margin-bottom:2px;">Jarak POP: ${marker.jarak_pop} m</p>
                        <p style="color:black;margin-bottom:2px;">Alamat: ${marker.alamat}</p>
                        <p style="color:black;margin-bottom:2px;">Latitude : ${marker.latitude}</p>
                        <p style="color:black;margin-bottom:2px;">Longitude : ${marker.longitude}</p>
                        <p style="color:black;margin-bottom:2px;">Keterangan: ${marker.keterangan}</p>
                        <p style="color:black;margin-bottom:2px;">Dokumentasi:</p>
                        <p></p><img src="${marker.doc}" style="width:100px;"></p>
                    </div>`;
                var theIcon = `${marker.marker_icon}`;
                var icon = {
                    url: theIcon,
                    scaledSize: new google.maps.Size(20, 20)
                };
                marker1 = new google.maps.Marker({
                    title: title,
                    position: pos,
                    map: map,
                    icon: icon
                });

                gmarkers1.push(marker1);

                // Marker click listener
                google.maps.event.addListener(marker1, 'click', (function(marker1, content) {
                    return function() {
                        infowindow.setContent(content);
                        infowindow.open(map, marker1);
                        map.panTo(this.getPosition());
                    }
                })(marker1, content));
            }
            filterMarkers = function(category) {
                for (i = 0; i < gmarkers1.length; i++) {
                    marker = gmarkers1[i];
                    // If is same category or category not picked
                    if (marker.category == category || category.length === 0) {
                        //Close InfoWindows
                        marker.setVisible(true);
                        if (infowindow) {
                            infowindow.close();
                        }
                    }
                    // Categories don't match
                    else {
                        marker.setVisible(false);
                    }
                }
            }


            function addMarkerTimeslot(marker) {
                var title = marker["customer_id"];
                var pos = new google.maps.LatLng(marker["latitude"], marker["longitude"]);

                var content = `<div class="keterangan">
                        <div style="color:black;font-size:16px;font-weight:bold;">Cust ID: ${marker.customer_id}</div>
                        <p style="color:black;margin-bottom:2px;">Customer Name: <span style="color:black"> ${marker.customer_name} </span></p>
                        <p style="color:black;margin-bottom:2px;">Alamat: ${marker.customer_address}</p>
                        <p style="color:black;margin-bottom:2px;">Latitude : ${marker.latitude}</p>
                        <p style="color:black;margin-bottom:2px;">Longitude : ${marker.longitude}</p>
                        <p style="color:black;margin-bottom:2px;">ODP: ${marker.odp}</p>
                        <p style="color:black;margin-bottom:2px;">ONT: ${marker.ont}</p>
                        <p style="color:black;margin-bottom:2px;">Serial Number: ${marker.serial_number}</p>
                        <p style="color:black;margin-bottom:2px;">Cable Distance: ${marker.cable_distance}</p>
                        <p style="color:black;margin-bottom:2px;">Dokumentasi:</p>
                        <p></p><img src="${marker.doc}" style="width:100px;"></p>
                    </div>`;
                var theIcon = `${marker.marker_icon}`;
                var icon = {
                    url: theIcon,
                    scaledSize: new google.maps.Size(20, 20)
                };
                marker1 = new google.maps.Marker({
                    title: title,
                    position: pos,
                    map: map,
                    icon: icon
                });

                gmarkers1.push(marker1);

                // Marker click listener
                google.maps.event.addListener(marker1, 'click', (function(marker1, content) {
                    return function() {
                        infowindow.setContent(content);
                        infowindow.open(map, marker1);
                        map.panTo(this.getPosition());
                    }
                })(marker1, content));
            }
            filterMarkersTimeslot = function(category) {
                for (i = 0; i < gmarkers1.length; i++) {
                    marker = gmarkers1[i];
                    // If is same category or category not picked
                    if (marker.category == category || category.length === 0) {
                        //Close InfoWindows
                        marker.setVisible(true);
                        if (infowindow) {
                            infowindow.close();
                        }
                    }
                    // Categories don't match
                    else {
                        marker.setVisible(false);
                    }
                }
            }

            // Init map
            initialize();
        })
    </script>
@endpush
