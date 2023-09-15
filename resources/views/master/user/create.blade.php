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
                                    <a href="{{ route('dashboard.user.index') }}" class="btn btn-warning">Kembali</a>
                                </div>
                                <hr>

                                @include('components.flash_messages')

                                <form class="row g-4 needs-validation myForm" method="POST"
                                    action="{{ route('dashboard.user.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-4">
                                        <div class="form-group mb-3 col-md-8">
                                            <label class="form-label">Nama</label>
                                            <span class="desc"></span>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name') }}" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 col-md-4">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <span class="desc"></span>
                                            <div class="controls">
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ old('email') }}">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 col-md-4">
                                            <label class="form-label">Username <span class="text-danger">*</span></label>
                                            <span class="desc"></span>
                                            <div class="controls">
                                                <input type="username" class="form-control" name="username"
                                                    value="{{ old('username') }}">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 col-md-3">
                                            <label class="form-label">Password</label>
                                            <span class="desc"></span>
                                            <div class="controls">
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 col-md-2">
                                            <label class="form-label">Role / Peran</label>
                                            <span class="desc"></span>
                                            <select name="role" id="role" class="form-control">
                                                @foreach (config('roles') as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 col-md-3">
                                            <label class="form-label">No Telp</label>
                                            <span class="desc"></span>
                                            <div class="controls">
                                                <input type="number" class="form-control" name="phone"
                                                    value="{{ old('phone') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3 col-md-3">
                                            <label class="form-label">Foto</label>
                                            <span class="desc"></span>
                                            <div class="controls">
                                                <input type="file" class="form-control" name="foto">
                                            </div>
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
