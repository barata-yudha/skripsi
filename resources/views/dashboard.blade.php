@extends('layouts.admin')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="page-title">Dashboard</h6>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Selamat datang {{ Auth::user()->name }}</li>
                            </ol>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="card mini-stat bg-primary text-white">
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="float-start mini-stat-img me-4">
                                        <img src="{{ asset('veltrix') }}/assets/images/services-icon/01.png" alt="">
                                    </div>
                                    <h5 class="font-size-16 text-uppercase text-white-50">Total ODP</h5>
                                    <h4 class="fw-medium font-size-24">{{ $total_odp }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card mini-stat bg-primary text-white">
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="float-start mini-stat-img me-4">
                                        <img src="{{ asset('veltrix') }}/assets/images/services-icon/01.png" alt="">
                                    </div>
                                    <h5 class="font-size-16 text-uppercase text-white-50">Customer</h5>
                                    <h4 class="fw-medium font-size-24">{{ $total_customer }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card mini-stat bg-primary text-white">
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="float-start mini-stat-img me-4">
                                        <img src="{{ asset('veltrix') }}/assets/images/services-icon/01.png" alt="">
                                    </div>
                                    <h5 class="font-size-16 text-uppercase text-white-50">Ticket Open</h5>
                                    <h4 class="fw-medium font-size-24">{{ $total_open }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card mini-stat bg-primary text-white">
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="float-start mini-stat-img me-4">
                                        <img src="{{ asset('veltrix') }}/assets/images/services-icon/01.png" alt="">
                                    </div>
                                    <h5 class="font-size-16 text-uppercase text-white-50">Ticket Progress</h5>
                                    <h4 class="fw-medium font-size-24">{{ $total_progress }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card mini-stat bg-primary text-white">
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="float-start mini-stat-img me-4">
                                        <img src="{{ asset('veltrix') }}/assets/images/services-icon/01.png" alt="">
                                    </div>
                                    <h5 class="font-size-16 text-uppercase text-white-50">Ticket Solved</h5>
                                    <h4 class="fw-medium font-size-24">{{ $total_solved }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        @include('components.footer')
        <!-- End Page-content -->
    </div>
@endsection
