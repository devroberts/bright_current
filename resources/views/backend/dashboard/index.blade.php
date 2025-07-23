@extends('backend.layouts.master')
@section('title') {{'Dashboard'}} @endsection

@section('breadcrumb') Pages / Dashboard @endsection
@section('page-title') Main Dashboard @endsection

@section('content')
@include('backend.partials.alert')
<div class="row gy-4">
{{--        Performance chart--}}
    <div class="col-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <h6 class="mb-2 fw-bold text-2xl">System Performance Overview</h6>
                    <div class="d-flex justify-content-center gap-36 align-items-center">
                        <ul class="d-flex flex-wrap align-items-center gap-24">
                            <li class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px rounded-circle" style="background-color: #2B3674"></span>
                                <span class="text-secondary-light text-sm fw-semibold">Total Production</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px rounded-circle" style="background-color: #D9D9D9"></span>
                                <span class="text-secondary-light text-sm fw-semibold">Expected Output</span>
                            </li>
                        </ul>
                        <select id="periodSelect" class="form-select form-select-sm w-auto border-primary text-secondary-light radius-8" style="padding: 0.25rem 1.5rem !important;">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                </div>
                <div class="mt-40">
                    <div id="systemPerformanceAreaChart" class="margin-16-minus"></div>
                </div>
            </div>
        </div>
    </div>

{{--        Quick links--}}
    <div class="col-12">
        <h4 class="mb-16">Quick Links</h6>
        <div class="row gy-4">
            <div class="col-xxl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="fw-semibold text-primary-semi-light">Active Alerts</div>
                        <h2>12</h4>
                        <div class="text-primary-semi-light"><i class="ri-arrow-up-line text-xxl me-14 w-auto"></i> 4 new since yesterday</div>
                        <a href="/dashboard/alert" class="color-brand py-4">View all alerts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--        Quick links--}}
    <div class="col-12">
        <div class="row gy-4 text-center">
            <div class="col-lg-3 col-sm-6">
                <div class="card px-24 py-36 shadow-none radius-12 border" style="height: 134px;">
                    <a href="/dashboard/service-schedules">
                        <div class="card-body p-0">
                            <i class="ri-calendar-todo-line text-xxl me-14 w-auto"></i>
                            <h6 class="fw-semibold mb-0">Schedule Service</h6>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card px-24 py-36 shadow-none radius-12 border" style="height: 134px;">
                    <a href="/dashboard/reports">
                        <div class="card-body p-0">
                            <i class="ri-upload-2-line text-xxl me-14 w-auto"></i>
                            <h6 class="fw-semibold mb-0">Export Reports</h6>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card px-24 py-36 shadow-none radius-12 border" style="height: 134px;">
                    <a href="/dashboard/system">
                        <div class="card-body p-0">
                            <i class="ri-add-fill text-xxl me-14 w-auto"></i>
                            <h6 class="fw-semibold mb-0">Add</h6>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card px-24 py-36 shadow-none radius-12 border" style="height: 134px;">
                    <a href="/dashboard/settings">
                        <div class="card-body p-0">
                            <i class="ri-user-add-line text-xxl me-14 w-auto"></i>
                            <h6 class="fw-semibold mb-0">Invite User</h6>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{--Recent Alerts--}}
    <div class="col-xxl-12">
        <div class="card h-100" style="padding-bottom: 80px;">
            <div class="card-header">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <h6 class="fw-bold mb-0" style="font-size: 22px;">Recent Alerts</h6>
                    <!-- <a href="javascript:void(0)" class="text-primary-light d-flex align-items-center gap-1">
                        View All
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                    </a> -->
                </div>
            </div>
            <div class="card-body" style="padding: 0 !important">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                        <tr>
                            <th scope="col" style="
  padding: 16px 16px 16px 42px !important;">SYSTEM ID</th>
                            <th scope="col">LOCATION</th>
                            <th scope="col">SYSTEM STATUS</th>
                            <th scope="col">STATUS UPDATE</th>
                            <th scope="col">INFO PLACEHOLDER</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="padding: 16px 16px 16px 42px !important;">
                                <span class="text-secondary-light">BC-2025-0123</span>
                            </td>
                            <td>
                                <span class="text-secondary-light">Oakland, CA</span>
                            </td>
                            <td>
                                <div class="text-secondary-light">
                                    <span class="bg-red text-white px-16 py-4 radius-12 fw-bold text-sm">Placeholder</span>
                                </div>
                            </td>
                            <td>
                                <span class="bg-yellow text-black px-16 py-4 radius-12 fw-bold text-sm">SCHEDULING</span>
                            </td>
                            <td>
                                <span class="text-secondary-light">12.4 kWh</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 16px 16px 16px 42px !important; border-radius: 0 !important;">
                                <span class="text-secondary-light">BC-2025-0123</span>
                            </td>
                            <td>
                                <span class="text-secondary-light">Oakland, CA</span>
                            </td>
                            <td>
                                <div class="text-secondary-light">
                                    <span class="bg-red text-white px-16 py-4 radius-12 fw-bold text-sm">Placeholder</span>
                                </div>
                            </td>
                            <td>
                                <span class="bg-yellow text-black px-16 py-4 radius-12 fw-bold text-sm">SCHEDULING</span>
                            </td>
                            <td style="border-radius: 0 !important;">
                                <span class="text-secondary-light">12.4 kWh</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Initialize chart
        let chart;

        // Sample data for different time periods
        const data = {
            daily: {
                categories: ['Jan 1', 'Jan 2', 'Jan 3', 'Jan 4', 'Jan 5', 'Jan 6', 'Jan 7'],
                series: [
                    {
                        name: 'Total Production',
                        data: [30, 40, 35, 50, 49, 60, 70]
                    },
                    {
                        name: 'Expected Output',
                        data: [40, 45, 40, 55, 60, 65, 75]
                    }
                ]
            },
            weekly: {
                categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                series: [
                    {
                        name: 'Total Production',
                        data: [210, 280, 315, 400]
                    },
                    {
                        name: 'Expected Output',
                        data: [280, 300, 350, 420]
                    }
                ]
            },
            monthly: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                series: [
                    {
                        name: 'Total Production',
                        data: [1200, 1500, 1800, 2100, 2400, 2700]
                    },
                    {
                        name: 'Expected Output',
                        data: [1500, 1600, 1900, 2200, 2500, 2800]
                    }
                ]
            }
        };

        // Function to render chart
        function renderChart(period) {
            const chartData = data[period];

            const options = {
                series: chartData.series,
                chart: {
                    type: 'area',
                    stacked: true,
                    height: 350,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: false
                    },
                    parentHeightOffset: 0,
                },
                colors: ['#2B3674', '#D9D9D9'], // Matches your dot colors
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.45,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                },
                legend: {
                    show: false // We're using custom legend in HTML
                },
                grid: {
                    show: true,
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4,
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                },
                xaxis: {
                    categories: chartData.categories,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontSize: '12px',
                            fontFamily: 'inherit'
                        }
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontSize: '12px',
                            fontFamily: 'inherit'
                        },
                        formatter: function (val) {
                            return val.toFixed(0);
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'inherit'
                    },
                    y: {
                        formatter: function (val) {
                            return val + " units";
                        }
                    }
                }
            };

            if (chart) {
                chart.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#systemPerformanceAreaChart"), options);
                chart.render();
            }
        }

        // Initialize with daily data
        document.addEventListener('DOMContentLoaded', function() {
            renderChart('daily');

            // Add event listener to select dropdown
            document.getElementById('periodSelect').addEventListener('change', function() {
                const period = this.value;
                renderChart(period);
            });
        });
    </script>
@endpush
