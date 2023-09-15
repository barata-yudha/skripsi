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
                                    <a href="{{ route('dashboard.odp.index') }}" class="btn btn-warning">Kembali</a>
                                </div>
                                <hr>

                                @include('components.flash_messages')

                                <form class="row g-4 needs-validation myForm" method="POST"
                                    action="{{ route('dashboard.odp.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-4">
                                        <label class="form-label">Kode ODP</label>
                                        <input type="text" class="form-control" name="kode" value="{{ old('kode') }}" required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Power</label>
                                        <input type="text" class="form-control" name="power" value="{{ old('power') }}" required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address" class="form-control" id="searchTextField"
                                                    runat="server" rows="2" autocomplete="false"
                                                    placeholder="Cari Lokasi">{{ old('address') }}</textarea>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-10">
                                        <label class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}" required="">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Port</label>
                                        <select name="port_max" id="port_max" class="form-control">
                                            <option value="8">0/8</option>
                                            <option value="16">0/16</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Koordinat Lokasi</label>
                                            <div id="gmap"  style="height: 450px;"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Latitude</label>
                                                    <input type="text" class="form-control" name="latitude" value="{{ old('latitude') }}"
                                                        id="latitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Longitude</label>
                                                    <input type="text" class="form-control" name="longitude" value="{{ old('longitude') }}"
                                                        id="longitude">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Icon</label>
                                            <input type="file" class="form-control" name="icon">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Lampiran/Dokumentasi</label>
                                            <input type="file" class="form-control" name="doc">
                                        </div>
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
