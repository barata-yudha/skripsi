@extends('layouts.admin')
@push('css')
    <style>
        .sqs-block-map {
            pointer-events: none;
        }
    </style>
@endpush
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
                                    <a href="{{ route('dashboard.timeslot.open') }}" class="btn btn-warning">Kembali</a>
                                </div>
                                <hr>

                                @include('components.flash_messages')

                                <div class="row g-3 needs-validation myForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-3">
                                        <label class="form-label">Customer</label>
                                        <input type="text" value="{{ $data->customer->nama }}"
                                            class="form-control disabled bg-secondary" disabled readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Customer ID</label>
                                        <input type="text" value="{{ $data->customer->id }}"
                                            class="form-control disabled bg-secondary" disabled readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Address</label>
                                        <input type="text" value="{{ $data->customer->alamat }}"
                                            class="form-control disabled bg-secondary" disabled readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" value="{{ $data->customer->no_hp }}"
                                            class="form-control disabled bg-secondary" disabled readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">ONT</label>
                                        <input type="text" value="{{ $data->ont->nama_lengkap }}"
                                            class="form-control disabled bg-secondary" disabled readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">ODP</label>
                                        <input type="text" value="{{ $data->odp->kode }}"
                                            class="form-control disabled bg-secondary" disabled readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Serial Number</label>
                                        <input type="text" class="form-control disabled bg-secondary"
                                            name="serial_number" value="{{ $data->serial_number }}" disabled readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Cable Distance</label>
                                        <input type="text" class="form-control disabled bg-secondary"
                                            name="cable_distance" value="{{ $data->cable_distance }}" disabled readonly>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label>Koordinat Lokasi</label>
                                            <div id="gmap" style="height: 300px;"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Latitude</label>
                                                    <input type="text" class="form-control bg-secondary" name="latitude"
                                                        value="{{ $data->latitude }}" id="latitude" disabled readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Longitude</label>
                                                    <input type="text" class="form-control bg-secondary" name="longitude"
                                                        value="{{ $data->longitude }}" id="longitude" disabled readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label>Lampiran/Dokumentasi</label>
                                                @if ($data->doc)
                                                    <br>
                                                    <img src="{{ MyHelper::get_avatar($data->doc) }}" alt=""
                                                        style="width: 100%;">
                                                    <br><br>
                                                @endif
                                            </div>
                                            <form action="{{ route('dashboard.ticket.approve', $data->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="confirmButton btn btn-success w-100"
                                                    onclick="return confirm('Yakin?')">Approve</button>
                                            </form>
                                            <form action="{{ route('dashboard.ticket.reject', $data->id) }}" method="POST"
                                                class="pt-2">
                                                @csrf
                                                <button type="submit"
                                                    class="confirmTolakButton btn btn-danger w-100">Reject</button>
                                            </form>
                                        </div>
                                    </div>
                                </div </div>
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
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ env('GMAP_API_KEY') }}&callback=initMap" defer>
        </script>

        <script>
            latitude = {{ $data->latitude }}
            longitude = {{ $data->longitude }}

            function initMap() {
                const myLatLng = {
                    lat: latitude,
                    lng: longitude
                };
                const map = new google.maps.Map(document.getElementById("gmap"), {
                    zoom: 15,
                    center: myLatLng,
                });

                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "Hello World!",
                });
            }

            $(document).ready(function() {
                window.initMap = initMap;
            })
        </script>
    @endpush
