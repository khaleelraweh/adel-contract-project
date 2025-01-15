@extends('layouts.admin')


@section('script')
    <script>
        $(function() {
            'use strict';

            var colors = {
                primary: "#6571ff",
                secondary: "#7987a1",
                success: "#05a34a",
                info: "#66d1d1",
                warning: "#fbbc06",
                danger: "#ff3366",
                light: "#e9ecef",
                dark: "#060c17",
                muted: "#7987a1",
                gridBorder: "rgba(77, 138, 240, .15)",
                bodyColor: "#000",
                cardBg: "#fff"
            };

            var fontFamily = "'Roboto', Helvetica, sans-serif";

            // Monthly Sales Chart - RTL
            if ($('#monthlySalesChartRTL').length) {
                const monthlySalesData = document.getElementById('monthlySalesData');
                const categories = JSON.parse(monthlySalesData.getAttribute('data-categories'));
                const counts = JSON.parse(monthlySalesData.getAttribute('data-counts'));

                console.log("Categories:", categories); // Debugging: Check if categories are correct
                console.log("Counts:", counts); // Debugging: Check if counts are correct

                var options = {
                    chart: {
                        type: 'bar',
                        height: '318',
                        parentHeightOffset: 0,
                        foreColor: colors.bodyColor,
                        background: colors.cardBg,
                        toolbar: {
                            show: false
                        },
                    },
                    theme: {
                        mode: 'light'
                    },
                    tooltip: {
                        theme: 'light'
                    },
                    colors: [colors.primary],
                    fill: {
                        opacity: .9
                    },
                    grid: {
                        padding: {
                            bottom: -4
                        },
                        borderColor: colors.gridBorder,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    series: [{
                        name: 'وثائق',
                        data: counts // Use dynamic counts here
                    }],
                    xaxis: {
                        type: 'category', // Use 'category' for non-datetime data
                        categories: categories, // Use dynamic categories here
                        axisBorder: {
                            color: colors.gridBorder,
                        },
                        axisTicks: {
                            color: colors.gridBorder,
                        },
                    },
                    yaxis: {
                        opposite: true, // RTL-specific: Y-axis on the right
                        title: {
                            text: 'Number of Sales',
                            offsetX: -100, // Adjust for RTL
                            style: {
                                size: 9,
                                color: colors.muted
                            }
                        },
                        labels: {
                            align: 'left', // Align labels to the left for RTL
                            offsetX: -20, // Adjust for RTL
                        },
                    },
                    legend: {
                        show: true,
                        position: "top",
                        horizontalAlign: 'center',
                        fontFamily: fontFamily,
                        itemMargin: {
                            horizontal: 8,
                            vertical: 0
                        },
                    },
                    stroke: {
                        width: 0
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '10px',
                            fontFamily: fontFamily,
                        },
                        offsetY: -27
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "50%",
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top',
                                orientation: 'vertical',
                            }
                        },
                    },
                };

                var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChartRTL"), options);
                apexBarChart.render();
            }
            // Monthly Sales Chart - RTL - END
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">{{ __('panel.welcome_back') }}</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            {{-- <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                        data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="printer"></i>
                Print
            </button>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Download Report
            </button> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">{{ __('panel.number_of_document_today') }}</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $numberOfDocumentsToday }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+{{ $percentageIncrease }}%</span> <!-- Percentage increase -->
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                    {{-- <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+3.3%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div> --}}
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">{{ __('panel.number_of_completed_documents') }}</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $numberOfCompletedDocuments }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-danger">
                                            <span>-2.8%</span>
                                            <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">{{ __('panel.number_of_incomplete_documents') }}</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $numberOfCompletedDocuments }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+2.8%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- for resource --}}
                {{-- <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">{{ __('panel.number_of_incomplete_documents') }}</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">89.87%</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+2.8%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div> <!-- row -->

    <div class="row">
        <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">{{ __('panel.monthly_documents') }}</h6>

                    </div>
                    <p class="text-muted">
                        {{ __('panel.Monthly_documents_are_documents_that_have_been_added_within_the_last_12_months_so_far') }}
                    </p>
                    <!-- Hidden element to pass data to JavaScript -->
                    <div id="monthlySalesData" data-categories="{{ json_encode($monthlySalesCategories) }}"
                        data-counts="{{ json_encode($monthlySalesCounts) }}">
                    </div>
                    {{-- <div id="monthlySalesChart"></div> --}}

                    {{-- <div id="monthlySalesChartRTL" style="border: 1px solid red;"></div> --}}
                    <div id="monthlySalesChartRTL"></div>
                </div>
            </div>
        </div>

    </div> <!-- row -->
@endsection
