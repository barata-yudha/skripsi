<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>{{ $title ?? env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ env('APP_NAME') }}" name="description">
    <meta content="{{ env('APP_AUTHOR') }}" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}">

    <link href="{{ asset('veltrix') }}/assets/libs/chartist/chartist.min.css" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link href="{{ asset('veltrix') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('veltrix') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('veltrix') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">

    <link href="{{ asset('veltrix') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('veltrix/assets/libs/select2/select2.min.css') }}">

    @if (isset($datatable))
        <!-- DataTables -->
        <link href="{{ asset('veltrix') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css"
            rel="stylesheet" type="text/css">
        <link href="{{ asset('veltrix') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
            rel="stylesheet" type="text/css">

        <!-- Responsive datatable examples -->
        {{-- <link href="{{ asset('veltrix') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"> --}}
    @endif


    <style>
        .centerMarker {
            position: absolute;
            /*url of the marker*/
            background: url(http://maps.gstatic.com/mapfiles/markers2/marker.png) no-repeat;
            /*center the marker*/
            top: 50%;
            left: 50%;
            z-index: 1;
            /*fix offset when needed*/
            margin-left: -10px;
            margin-top: -34px;
            /*size of the image*/
            height: 34px;
            width: 20px;
            cursor: pointer;
            color: black;
        }

        .keterangan>* {
            color: black !important;
        }
    </style>

    <style>
        [data-letters]:before {
            content: attr(data-letters);
            display: inline-block;
            font-size: 1em;
            width: 2.5em;
            height: 2.5em;
            line-height: 2.5em;
            text-align: center;
            border-radius: 50%;
            background: plum;
            vertical-align: middle;
            margin-right: 1em;
            color: white;
        }

        .amchart {
            width: 100%;
            height: 500px;
        }
    </style>

    <style>
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }

        .select2-container--default .select2-selection--single {
            height: 37px !important;
            padding: 6px 8px;
            font-size: 13px;
            line-height: 1.33;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 85% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #CCC !important;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        }
    </style>

    @stack('css')

</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('img/fav.png') }}" alt="" style="width: 30px;">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('img/logo.png') }}" alt="" style="width: 180px;">
                            </span>
                        </a>

                        <a href="{{ route('dashboard.index') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('img/fav.png') }}" alt="" style="width: 30px;">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('img/logo.png') }}" alt="" style="width: 180px;">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-none d-md-block ms-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            data-bs-toggle="fullscreen">
                            <i class="mdi mdi-fullscreen"></i>
                        </button>
                    </div>

                    @php
                        $odps = App\Models\Odp::all();
                        $warned = $odps->map(function ($odp) {
                            $check_sisa = $odp->port_max - $odp->port_used;
                            if ($check_sisa <= 2 && $check_sisa != 0) {
                                return (object) [
                                    'id' => $odp->id,
                                    'kode' => $odp->kode,
                                    'sisa_port' => $odp->port_max - $odp->port_used,
                                    'port' => $odp->port_used . '/' . $odp->port_max,
                                ];
                            }
                        });

                        $warned = array_filter($warned->toArray());
                    @endphp

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-bell-outline"></i>
                            <span class="badge bg-danger rounded-pill">{{ count($warned) }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notifikasi ({{ count($warned) }}) </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">

                                @foreach ($warned as $item)
                                    <a href="#" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-danger rounded-circle font-size-16">
                                                        <i class="mdi mdi-message-text-outline"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $item->kode }} Hampir Penuh</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">{{ $item->port }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! MyHelper::avatarUser(Auth::user(), '40px') !!}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ route('dashboard.user.profile') }}"><i
                                    class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                            <div class="dropdown-divider"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                this.closest('form').submit();"><i
                                        class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i>
                                    Logout</a>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Main</li>

                        @if (in_array(Auth::user()->role, ['admin', 'teknisi', 'owner']))
                            <li>
                                <a href="{{ route('dashboard.index') }}" class="waves-effect">
                                    <i class="ti-home"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            @if (in_array(Auth::user()->role, ['admin', 'teknisi', 'owner']))

                                @if (in_array(Auth::user()->role, ['admin', 'teknisi']))

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <i class="ti-email"></i>
                                            <span>Master Data</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="{{ route('dashboard.odp.index') }}">ODP</a></li>
                                            <li><a href="{{ route('dashboard.ont.index') }}">ONT</a></li>

                                            @if (in_array(Auth::user()->role, ['admin']))
                                                <li><a href="{{ route('dashboard.customer.index') }}">Customer</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif

                                <li>
                                    <a href="{{ route('dashboard.my_area') }}" class=" waves-effect">
                                        <i class="fas fa-map"></i>
                                        <span>My Area</span>
                                    </a>
                                </li>
                            @endif

                            @if (in_array(Auth::user()->role, ['admin']))
                                <li>
                                    <a href="{{ route('dashboard.check_coverage') }}" class=" waves-effect">
                                        <i class="fas fa-check"></i>
                                        <span>Check Coverage</span>
                                    </a>
                                </li>
                            @endif

                            @if (in_array(Auth::user()->role, ['teknisi']))
                                <li>
                                    <a href="{{ route('dashboard.timeslot.index') }}" class=" waves-effect">
                                        <i class="ti-calendar"></i>
                                        <span>Timeslot</span>
                                    </a>
                                </li>
                            @endif

                            @if (in_array(Auth::user()->role, ['admin', 'owner']))
                                <li>
                                    <a href="{{ route('dashboard.timeslot.open') }}" class=" waves-effect">
                                        <i class="fas fa-book"></i>
                                        <span>Ticket</span>
                                    </a>
                                </li>

                                @if (in_array(Auth::user()->role, ['admin', 'owner']))
                                    <li>
                                        <a href="{{ route('dashboard.user.index') }}" class=" waves-effect">
                                            <i class="fas fa-users"></i>
                                            <span>Account Control</span>
                                        </a>
                                    </li>
                                @endif
                            @endif

                            @if (in_array(Auth::user()->role, ['admin', 'owner']))
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="ti-book"></i>
                                        <span>Laporan</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="{{ route('dashboard.laporan.periode') }}">Rekapitulasi</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    {{-- <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-end">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('veltrix') }}/assets/images/layouts/layout-1.jpg"
                        class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('veltrix') }}/assets/images/layouts/layout-2.jpg"
                        class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"
                        data-bsStyle="assets/css/bootstrap-dark.min.html"
                        data-appStyle="assets/css/app-dark.min.html" />
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('veltrix') }}/assets/images/layouts/layout-3.jpg"
                        class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-5">
                    <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch"
                        data-appStyle="assets/css/app-rtl.min.css" />
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>
                <div class="d-grid">
                    <a href="https://1.envato.market/grNDB" class="btn btn-primary mt-3" target="_blank"><i
                            class="mdi mdi-cart me-1"></i> Purchase Now</a>
                </div>
            </div>

        </div> <!-- end slimscroll-menu-->
    </div> --}}
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('veltrix') }}/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/node-waves/waves.min.js"></script>


    <!-- Peity chart-->
    <script src="{{ asset('veltrix') }}/assets/libs/peity/jquery.peity.min.js"></script>

    <!-- Plugin Js-->
    <script src="{{ asset('veltrix') }}/assets/libs/chartist/chartist.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js"></script>

    <script src="{{ asset('veltrix') }}/assets/js/pages/dashboard.init.js"></script>

    <script>
        var baseUrl = "{{ asset('veltrix') }}";
    </script>
    <script src="{{ asset('veltrix') }}/assets/js/app.js"></script>

    <script src="{{ asset('veltrix/assets/libs/select2/select2.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('veltrix') }}/assets/libs/apexcharts/apexcharts.min.js"></script>

    @if (isset($datatable))
        <!-- Required datatable js -->
        <script src="{{ asset('veltrix') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('veltrix') }}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('veltrix') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{ asset('veltrix') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="{{ asset('veltrix') }}/assets/libs/jszip/jszip.min.js"></script>
        {{-- <script src="{{ asset('veltrix') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="{{ asset('veltrix') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script> --}}
        <script src="{{ asset('veltrix') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{ asset('veltrix') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{ asset('veltrix') }}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        {{-- Sweetalert 2 --}}
        <script src="{{ asset('veltrix') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    @endif


    <script>
        var longitude = {{ env('LONG_DEFAULT') }};
        var latitude = {{ env('LAT_DEFAULT') }};

        $(".myForm").on('submit', function(event) {
            $(".formSubmitter").attr('disabled', true).addClass('disabled');
            $(".myForm").attr('onsubmit', 'return false');
        });

        $('.select2').select2();

        $(document).on('click', '.buttonDeletion', function(e) {
            e.preventDefault();
            let form = $(this).parents('form');

            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                text: "Data yang dihapus tidak bisa dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((Delete) => {
                if (Delete.isConfirmed) {
                    form.submit()
                    swal({
                        title: 'Dikonfirmasi!',
                        text: 'Data akan dihapus.',
                        icon: 'success',
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    });
                } else {
                    swal.close();
                }
            });
        })
    </script>

    @stack('js')
</body>

</html>
