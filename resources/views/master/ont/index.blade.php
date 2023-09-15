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
                                    <a href="{{ route('dashboard.ont.create') }}" class="btn btn-primary">Tambah</a>
                                </div>
                                @include('components.flash_messages')
                                <div class="table-responsive">
                                    {{ $dataTable->table(['class' => ['table table-bordered dt-responsive nowrap w-100'], 'id' => 'datatable-buttons']) }}
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
