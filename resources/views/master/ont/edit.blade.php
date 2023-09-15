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
                                    <a href="{{ route('dashboard.ont.index') }}" class="btn btn-warning">Kembali</a>
                                </div>
                                <hr>

                                @include('components.flash_messages')

                                <form class="row g-3 needs-validation myForm" method="POST"
                                    action="{{ route('dashboard.ont.update', $data->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-4">
                                        <label class="form-label">Merk ONT</label>
                                        <input type="text" class="form-control" name="merk_ont" value="{{ $data->merk_ont }}" required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Type ONT</label>
                                        <input type="text" class="form-control" name="type_ont" value="{{ $data->type_ont }}" required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Versi ONT</label>
                                        <input type="text" class="form-control" name="versi_ont" value="{{ $data->versi_ont }}" required="">
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <button class="btn btn-primary formSubmitter" type="submit">Simpan</button>
                                    </div>
                                    <!-- end col -->
                                </form>
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

@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ env('GMAP_API_KEY') }}&callback=initMap">
    </script>

    @include('components.script_coordinate')

    <script>
        latitude = {{ $data->latitude }}
        longitude = {{ $data->longitude }}
    </script>

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
@endpush
