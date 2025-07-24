@extends('backend.layouts.master')
@section('title') {{'System Details'}} @endsection

@section('breadcrumb') Pages / System @endsection
@section('page-title') System Details @endsection

@section('content')
    @include('backend.partials.alert')

    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h4 class="fw-semibold mb-0">{{ $system->customer_name }} ({{ $system->system_id }})</h4>
        <a href="{{ route('system.edit', $system->id) }}" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
            <iconify-icon icon="lucide:edit" class="icon text-xl line-height-1 me-2"></iconify-icon>
            Edit System
        </a>
    </div>

    <div class="row gy-4">
        {{-- System Information Card --}}
        <div class="col-xxl-12 col-xl-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">System Information</h6>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">System ID:</p>
                            <h6 class="mb-0 text-primary-light">{{ $system->system_id }}</h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Customer Name:</p>
                            <h6 class="mb-0 text-primary-light">{{ $system->customer_name }}</h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Customer Type:</p>
                            <h6 class="mb-0 text-primary-light">{{ ucfirst($system->customer_type) }}</h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Manufacturer:</p>
                            <h6 class="mb-0 text-primary-light">{{ $system->manufacturer }}</h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Status:</p>
                            <h6 class="mb-0 text-primary-light">
                            <span class="badge @if($system->status == 'active') bg-success-500 @elseif($system->status == 'warning') bg-warning-500 @elseif($system->status == 'critical') bg-danger-500 @else bg-neutral-500 @endif">
                                {{ ucfirst($system->status) }}
                            </span>
                            </h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Location:</p>
                            <h6 class="mb-0 text-primary-light">{{ $system->location }}</h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Capacity:</p>
                            <h6 class="mb-0 text-primary-light">{{ $system->capacity ? $system->capacity . ' kW' : 'N/A' }}</h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Install Date:</p>
                            <h6 class="mb-0 text-primary-light">{{ $system->install_date ? $system->install_date->format('M d, Y') : 'N/A' }}</h6>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <p class="text-secondary-light mb-1">Last Seen:</p>
                            <h6 class="mb-0 text-primary-light">{{ $system->last_seen ? $system->last_seen->diffForHumans() : 'N/A' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Production Data Chart --}}
        <div class="col-xxl-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Production History (Last 30 Days)</h6>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div id="productionDataChart"></div> {{-- Changed ID for clarity --}}
                </div>
            </div>
        </div>

        {{-- Alert History --}}
        <div class="col-xxl-12 col-xl-12">
            <div class="card basic-data-table">
                <div class="card-body" style="padding: 0 !important;">
                    <div class="d-flex align-items-center justify-content-between" style="padding: 22px 28px; border-bottom: 1px solid #e0e5f2;">
                        <h6 class="fw-bold text-lg mb-0">Alert History</h6>
                        <a href="{{ route('alert.index', ['system_keyword' => $system->system_id]) }}" class="btn-text text-primary-600">View All</a>
                    </div>
                    <table class="table bordered-table mb-0" id="alertsTable" data-page-length='5'>
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Severity</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($alerts as $alert)
                            <tr>
                                <td>{{ $alert->created_at->format('M d, Y H:i A') }}</td>
                                <td>
                                    <span class="text-white px-16 py-4 radius-12 fw-bold text-sm @if($alert->severity == 'critical') bg-danger @elseif($alert->severity == 'warning') bg-warning @else bg-info @endif">
                                        {{ ucfirst($alert->severity) }}
                                    </span>
                                </td>
                                <td>{{ $alert->alert_type }}</td>
                                <td>
                                    <span class="text-white px-16 py-4 radius-12 fw-bold text-sm @if($alert->status == 'resolved') bg-success @else bg-secondary @endif">
                                        {{ ucfirst($alert->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No alerts found for this system.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Service Schedules --}}
        <div class="col-xxl-12 col-xl-12">
            <div class="card basic-data-table">
                <div class="card-body" style="padding: 0 !important">
                    <div class="d-flex align-items-center justify-content-between" style="padding: 22px 28px; border-bottom: 1px solid #e0e5f2;">
                        <h6 class="fw-bold text-lg mb-0">Service Schedules</h6>
                        {{-- Assuming a route for all service schedules, or to create a new one for this system --}}
                        {{-- <a href="#" class="btn-text text-primary-600">View All</a> --}}
                    </div>
                    <table class="table bordered-table mb-0" id="serviceSchedulesTable" data-page-length='5'>
                        <thead>
                        <tr>
                            <th scope="col">Scheduled Date</th>
                            <th scope="col">Service Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Assigned Tech</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($serviceSchedules as $schedule)
                            <tr>
                                <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                                <td>{{ $schedule->service_type }}</td>
                                <td>
                                    <span class="text-white px-16 py-4 radius-12 fw-bold text-sm @if($schedule->status == 'completed') bg-success @elseif($schedule->status == 'cancelled') bg-danger @else bg-secondary @endif">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </td>
                                <td>{{ $schedule->assigned_technician ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No service schedules found for this system.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // ApexCharts for Production Data
        var optionsProduction = {
            series: [{
                name: 'Current Power (kW)',
                data: @json($powerCurrentData)
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: @json($productionLabels),
                labels: {
                    style: {
                        colors: '#A0AEC0',
                    },
                },
            },
            yaxis: {
                title: {
                    text: 'Power Output (kW)'
                },
                labels: {
                    formatter: function (value) {
                        return parseFloat(value).toFixed(1) + ' kW'; // Format as kW
                    },
                    style: {
                        colors: '#A0AEC0',
                    },
                },
                min: 0
            },
            tooltip: {
                x: {
                    format: 'dd MMM'
                },
                y: {
                    formatter: function (value) {
                        return parseFloat(value).toFixed(2) + ' kW';
                    }
                }
            },
            grid: {
                borderColor: '#f1f1f1',
            },
            colors: ['#4A2AD0'] // A primary color for production data
        };

        var chartProduction = new ApexCharts(document.querySelector("#productionDataChart"), optionsProduction);
        chartProduction.render();

        // Initialize DataTables for both tables
        $(document).ready(function() {
            $('#alertsTable').DataTable({
                scrollX: true,
                responsive: true,
                ordering: true,
                searching: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                language: {
                    search: "Search alerts:",
                    lengthMenu: "Show _MENU_ alerts",
                    info: "Showing _START_ to _END_ of _TOTAL_ alerts",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });

            $('#serviceSchedulesTable').DataTable({
                scrollX: true,
                responsive: true,
                ordering: true,
                searching: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                language: {
                    search: "Search schedules:",
                    lengthMenu: "Show _MENU_ schedules",
                    info: "Showing _START_ to _END_ of _TOTAL_ schedules",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        });
    </script>
@endpush
