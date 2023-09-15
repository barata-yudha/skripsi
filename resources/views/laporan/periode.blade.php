@extends('layouts.admin')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="page-title-box">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h4 class="page-title">{{ $title }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @include('components.flash_messages')
                                <form action="" method="GET" class="d-flex align-items-end gap-2 mb-3 no-print">
                                    <div class="form-group">
                                        <label>Dari</label>
                                        <input type="date" class="form-control" name="date_from"
                                            value="{{ $date_from ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sampai</label>
                                        <input type="date" class="form-control" name="date_to"
                                            value="{{ $date_to ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                        <a href="{{ route('dashboard.laporan.periode') }}" class="btn btn-danger">Reset</a>
                                    </div>
                                </form>
                                <h4 class="text-center">{{ $title }}</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-5">
                                        <div id="pie_chart" class="apex-charts" dir="ltr" style="width: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-5">
                                        <div id="stacked-column-chart" class="apex-charts" dir="ltr"
                                            style="width: 100%;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-5">
                                        <div id="odp_most" class="apex-charts" dir="ltr" style="width: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-5">
                                        <div id="top_customer" class="apex-charts" dir="ltr" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="text-right">
                                        <button class="btn btn-primary btn-sm no-print" onclick="window.print()">Cetak
                                            Laporan</button>
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
    <script>
        // Pie
        optionsPieGiat = {
            title: {
                text: "Rekapitulasi Per Status",
                align: 'center',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    fontFamily: "Arial",
                    color: '#000'
                },
            },
            chart: {
                height: 420,
                type: "pie",
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true | '<img src="/static/icons/reset.png" width="20">',
                        customIcons: []
                    },
                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ',',
                            headerCategory: 'category',
                            headerValue: 'value',
                            dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                            }
                        },
                        svg: {
                            filename: undefined,
                        },
                        png: {
                            filename: undefined,
                        }
                    },
                    autoSelected: 'zoom'
                },
            },
            series: {!! json_encode(array_values($top_status)) !!},
            labels: {!! json_encode(array_keys($top_status)) !!},
            colors: ["#34c38f", "#f46a6a", "#556ee6", "#50a5f1", "#f1b44c"],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                }
            }],
        };
        (chartPieGiat = new ApexCharts(document.querySelector("#pie_chart"), optionsPieGiat)).render();

        // Bar Per Admin
        var optionsBarPerBulan = {
            title: {
                text: "Ranking Per Admin",
                align: 'center',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    fontFamily: "Arial",
                    color: '#000'
                },
            },
            chart: {
                height: {{ count($top_admin) }}00,
                type: "bar",
                stacked: !0,
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true | '<img src="/static/icons/reset.png" width="20">',
                        customIcons: []
                    },
                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ',',
                            headerCategory: 'category',
                            headerValue: 'value',
                            dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                            }
                        },
                        svg: {
                            filename: undefined,
                        },
                        png: {
                            filename: undefined,
                        }
                    },
                    autoSelected: 'zoom'
                },
                zoom: {
                    enabled: !0
                },
            },

            plotOptions: {
                bar: {
                    horizontal: 1,
                    columnWidth: "15%",
                    endingShape: "rounded",
                    distributed: true,
                    dataLabels: {
                        position: 'top'
                    }
                },

            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: true,
                formatter: function(val, opts) {
                    return val
                },
                textAnchor: 'middle',
                distributed: false,
                offsetX: -10,
                offsetY: 0,
                style: {
                    fontSize: '14px',
                    fontFamily: 'Helvetica, Arial, sans-serif',
                    fontWeight: 'bold',
                    colors: ['#000']
                },
                background: {
                    enabled: true,
                    foreColor: '#fff',
                    padding: 4,
                    borderRadius: 2,
                    borderWidth: 1,
                    borderColor: '#fff',
                    opacity: 0.9,
                    dropShadow: {
                        enabled: false,
                        top: 1,
                        left: 1,
                        blur: 1,
                        color: '#000',
                        opacity: 0.45
                    }
                },

                dropShadow: {
                    enabled: false,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: '#000',
                    opacity: 0.45
                }
            },
            noData: {
                text: "Tidak ada data",
                align: "center",
                verticalAlign: "middle",
            },
            series: [{
                name: "Jumlah Timeslot",
                data: {!! json_encode(array_values($top_admin)) !!}
            }, ],
            xaxis: {
                categories: {!! json_encode(array_keys($top_admin)) !!}
            },
            theme: {
                palette: 'palette1' // upto palette10
            },
            legend: {
                position: "bottom"
            },
            fill: {
                opacity: 1
            },
        }
        chartBarPerBulan = new ApexCharts(document.querySelector("#stacked-column-chart"), optionsBarPerBulan);
        chartBarPerBulan.render();

        // Pie ODP Most
        optionsPieOdpMost = {
            title: {
                text: "Rekapitulasi Per ODP",
                align: 'center',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    fontFamily: "Arial",
                    color: '#000'
                },

                noData: {
                    text: "Tidak ada data",
                    align: "center",
                    verticalAlign: "middle",
                },
                series: [{
                    name: "Jumlah Ticket",
                    data: {!! json_encode(array_values($top_admin)) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($top_admin)) !!}
                },
                theme: {
                    palette: 'palette1' // upto palette10
                },
                legend: {
                    position: "bottom"
                },
                fill: {
                    opacity: 1
                },
            },
            chart: {
                height: 420,
                type: "pie",
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true | '<img src="/static/icons/reset.png" width="20">',
                        customIcons: []
                    },
                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ',',
                            headerCategory: 'category',
                            headerValue: 'value',
                            dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                            }
                        },
                        svg: {
                            filename: undefined,
                        },
                        png: {
                            filename: undefined,
                        }
                    },
                    autoSelected: 'zoom'
                },
            },
            series: {!! json_encode(array_values($top_odp)) !!},
            labels: {!! json_encode(array_keys($top_odp)) !!},
            colors: ["#34c38f", "#556ee6", "#f46a6a", "#50a5f1", "#f1b44c"],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                }
            }],
        };
        (chartPieGiat = new ApexCharts(document.querySelector("#odp_most"), optionsPieOdpMost)).render();

        // Bar Per Customer
        var optionsBarCustomerPerBulan = {
            title: {
                text: "Ranking Per Customer",
                align: 'center',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    fontFamily: "Arial",
                    color: '#000'
                },
            },
            chart: {
                height: {{ count($top_customer) }}00,
                type: "bar",
                stacked: !0,
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true | '<img src="/static/icons/reset.png" width="20">',
                        customIcons: []
                    },
                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ',',
                            headerCategory: 'category',
                            headerValue: 'value',
                            dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                            }
                        },
                        svg: {
                            filename: undefined,
                        },
                        png: {
                            filename: undefined,
                        }
                    },
                    autoSelected: 'zoom'
                },
                zoom: {
                    enabled: !0
                },
            },

            plotOptions: {
                bar: {
                    horizontal: 1,
                    columnWidth: "15%",
                    endingShape: "rounded",
                    distributed: true,
                    dataLabels: {
                        position: 'top'
                    }
                },

            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: true,
                formatter: function(val, opts) {
                    return val
                },
                textAnchor: 'middle',
                distributed: false,
                offsetX: -10,
                offsetY: 0,
                style: {
                    fontSize: '14px',
                    fontFamily: 'Helvetica, Arial, sans-serif',
                    fontWeight: 'bold',
                    colors: ['#000']
                },
                background: {
                    enabled: true,
                    foreColor: '#fff',
                    padding: 4,
                    borderRadius: 2,
                    borderWidth: 1,
                    borderColor: '#fff',
                    opacity: 0.9,
                    dropShadow: {
                        enabled: false,
                        top: 1,
                        left: 1,
                        blur: 1,
                        color: '#000',
                        opacity: 0.45
                    }
                },
                dropShadow: {
                    enabled: false,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: '#000',
                    opacity: 0.45
                }
            },
            noData: {
                text: "Tidak ada data",
                align: "center",
                verticalAlign: "middle",
            },
            series: [{
                name: "Jumlah Timeslot",
                data: {!! json_encode(array_values($top_customer)) !!}
            }, ],
            xaxis: {
                categories: {!! json_encode(array_keys($top_customer)) !!}
            },
            theme: {
                palette: 'palette1' // upto palette10
            },
            legend: {
                position: "bottom"
            },
            fill: {
                opacity: 1
            },
        }
        chartBarCustomerPerBulan = new ApexCharts(document.querySelector("#top_customer"), optionsBarCustomerPerBulan);
        chartBarCustomerPerBulan.render();
    </script>
@endpush
