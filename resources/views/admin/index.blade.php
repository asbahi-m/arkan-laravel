@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card card-coin">
                <div class="card-body p-4">
                    <div class="media ai-icon">
                        <span class="mr-3 bgl-primary text-primary">
                            <i class="flaticon-077-menu-1"></i>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">{{ __('admin.services') }}</p>
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-0">{{ $products_count }}</h4>
                                <span class="badge badge-primary">
                                    <i class="fa fa-eye"></i>
                                    <span>{{ $services_views }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card card-coin">
                <div class="card-body p-4">
                    <div class="media ai-icon">
                        <span class="mr-3 bgl-success text-success">
                            <i class="fa fa-cubes"></i>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">{{ __('admin.products') }}</p>
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-0">{{ $products_count }}</h4>
                                <span class="badge badge-success">
                                    <i class="fa fa-eye"></i>
                                    <span>{{ $products_views }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card card-coin">
                <div class="card-body p-4">
                    <div class="media ai-icon">
                        <span class="mr-3 bgl-info text-info">
                            <i class="fa fa-clone"></i>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">{{ __('admin.projects') }}</p>
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-0">{{ $projects_count }}</h4>
                                <span class="badge badge-info">
                                    <i class="fa fa-eye"></i>
                                    <span>{{ $projects_views }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Views -->
    <div class="row">
        <!-- Views Last Week -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header border-0 flex-wrap pb-0">
                    <div class="mb-3">
                        <h4 class="fs-20 text-black">{{ __('admin.views_last_week') }}</h4>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div id="marketChart" class="market-line"></div>
                </div>
            </div>
        </div>

        <!-- Views Today, Weekly and Total Views -->
        <div class="col-lg-3">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-12">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">{{ __('admin.views_today') }}</h4>
                            <h3>{{ $views_today }}</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-info" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-12">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">{{ __('admin.views_weekly') }}</h4>
                            <h3>{{ $views_weekly }}</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-success" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-12">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">{{ __('admin.total_views') }}</h4>
                            <h3>{{ $views_count }}</h3>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-animated bg-primary" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <!-- Apex Chart -->
    <script src="{{ asset('admin/vendor/apexchart/apexchart.js') }}"></script>
    <script>
        (function ($) {

            var dzChartlist = (function () {
                var screenWidth = $(window).width();
                var marketChart = function () {
                    var options = {
                        series: {!! $data->toJson() !!},
                        chart: {
                            height: 350,
                            type: "area",
                            toolbar: {
                                show: false,
                            },
                        },
                        colors: ["#FFAB2D", "#00ADA3", "#EE627B", "#2C89C1", "#AE52C8", "#889D3C", "#A664E8"],
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            curve: "smooth",
                        },
                        legend: {
                            show: false,
                        },
                        grid: {
                            borderColor: "#EEEEEE",
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: "#787878",
                                    fontSize: "13px",
                                    fontFamily: "Poppins",
                                    fontWeight: 400,
                                },
                                formatter: function (value) {
                                    // return value + "k";
                                    return value;
                                },
                            },
                        },
                        xaxis: {
                            categories: {!! $dates->flatten() !!},
                            labels: {
                                style: {
                                    colors: "#787878",
                                    fontSize: "13px",
                                    fontFamily: "Poppins",
                                    fontWeight: 400,
                                },
                            },
                        },
                        tooltip: {
                            x: {
                                format: "dd/MM/yy HH:mm",
                            },
                        },
                    };

                    var chart = new ApexCharts(
                        document.querySelector("#marketChart"),
                        options
                    );
                    chart.render();
                };

                /* Function ============ */
                return {
                    init: function () {},

                    load: function () {
                        marketChart();
                    },

                    resize: function () {},
                };
            })();

            jQuery(window).on("load", function () {
                setTimeout(function () {
                    dzChartlist.load();
                }, 1000);
            });

            jQuery(window).on("resize", function () {});
        })(jQuery);
    </script>
@endsection
