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
                                    <a href="{{ route('dashboard.timeslot.index') }}" class="btn btn-warning">Kembali</a>
                                </div>
                                <hr>

                                @include('components.flash_messages')

                                <form class="row g-3 needs-validation myForm" method="POST"
                                    action="{{ route('dashboard.timeslot.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-4">
                                        <label class="form-label">Customer</label>
                                        <select name="customer_id" id="customer_id" class="form-control select2">
                                            <option value="">-- Pilih Customer --</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->nama . ' ('. $customer->id .')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">ONT</label>
                                        <select name="ont_id" id="ont_id" class="form-control select2">
                                            <option value="">-- Pilih ONT --</option>
                                            @foreach ($onts as $ont)
                                                <option value="{{ $ont->id }}">{{ $ont->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">ODP</label>
                                        <select name="odp_id" id="odp_id" class="form-control select2">
                                            <option value="">-- Pilih ODP --</option>
                                            @foreach ($odps as $odp)
                                                <option value="{{ $odp->id }}">{{ $odp->kode .' ('. $odp->port_used . '/' . $odp->port_max .')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Serial Number</label>
                                        <input type="text" class="form-control" name="serial_number" value="{{ old('serial_number') }}" required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Cable Distance</label>
                                        <input type="text" class="form-control" name="cable_distance" value="{{ old('cable_distance') }}" required="">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Shortcut GPS</label>
                                        <textarea name="address" class="form-control" id="searchTextField"
                                                    runat="server" rows="2" autocomplete="false"
                                                    placeholder="Cari Lokasi">{{ old('address') }}</textarea>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Koordinat Lokasi</label>
                                            <div id="gmap"  style="height: 300px;"></div>
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
@endpush
