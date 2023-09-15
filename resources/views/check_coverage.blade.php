@extends('layouts.admin')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <hr>

                                @include('components.flash_messages')

                                <form class="row g-3 needs-validation align-items-end myForm" method="GET"
                                    action="{{ route('dashboard.check_coverage') }}" enctype="multipart/form-data">
                                    <div class="col-md-4">
                                        <label class="form-label">Masukkan Tikor Pelanggan</label>
                                        <input type="text" class="form-control" name="tikor_pelanggan" value="{{ old('tikor_pelanggan') ?? $tikor_pelanggan }}" placeholder="Masukkan koordinat (-6.2324, 108.311344)" required="">
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-primary formSubmitter" type="submit">Check Coverage</button>
                                        <a href="{{ route('dashboard.check_coverage') }}" class="btn btn-warning">Reset</a>
                                    </div>
                                    <!-- end col -->
                                </form>

                                @if ($tikor_pelanggan)
                                    <hr>
                                    <div class="text-center">
                                        <h4>ODP Terdekat</h4>
                                    </div>
                                    <table class="table table-hover table-striped mt-5">
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Alamat</th>
                                            <th>Jarak (m)</th>
                                            <th>Port</th>
                                            <th>View</th>
                                        </tr>
                                        @foreach ($closest_odp as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['kode'] }}</td>
                                                <td>{{ $item['address'] }}</td>
                                                <td>{{ number_format($item['distance'], 0, ",", ".") }} m</td>
                                                <td>{{ $item['port'] }}</td>
                                                <td>{!! $item['direction_link'] !!}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('components.footer')
    </div>
@endsection
{{-- 
@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ env('GMAP_API_KEY') }}&callback=initMap">
    </script>

    @include('components.script_coordinate')

    <script>
        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            var latLong = new google.maps.LatLng(lat, lng);
            map.setCenter(latLong);

        });
    </script>
@endpush --}}
