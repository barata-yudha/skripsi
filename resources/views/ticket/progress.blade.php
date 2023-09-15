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
                                @include('components.flash_messages')

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.timeslot.open') }}">
                                            <span class="d-none d-md-block">Ticket Pending</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                        </a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link active" href="{{ route('dashboard.timeslot.progress') }}">
                                            <span class="d-none d-md-block">Ticket Progress</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.timeslot.solve') }}">
                                            <span class="d-none d-md-block">Ticket Solve</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.timeslot.reject') }}">
                                            <span class="d-none d-md-block">Ticket Reject</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane  p-3" id="home1x" role="tabpanel">
                                    </div>
                                    <div class="tab-pane active p-3" id="home1" role="tabpanel">
                                        <div class="table-responsive">
                                            {{ $dataTable->table(['class' => ['table table-bordered dt-responsive nowrap w-100'], 'id' => 'datatable-buttons']) }}
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="messages1" role="tabpanel">
                                    </div>
                                </div>

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
    {{ $dataTable->scripts() }}
@endpush
