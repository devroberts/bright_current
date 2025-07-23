@extends('backend.layouts.master')
@section('title') {{'System Details'}} @endsection

@section('breadcrumb') System / System Details @endsection
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
        <div class="col-xxl-12 col-xl-12"> {{-- Using col-xxl-6 to make it share row with Service Schedules on larger screens --}}
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="fw-bold text-lg mb-0">Alert History</h6>
                        <a href="{{ route('alert.index', ['system_keyword' => $system->system_id]) }}" class="btn-text text-primary-600">View All</a>
                    </div>
                </div>
                <div class="card-body" style="padding: 0 !important;">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Severity</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($alerts as $alert)
                                <tr>
                                    <td>{{ $alert->created_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        <span class="badge @if($alert->severity == 'critical') bg-danger-500 @elseif($alert->severity == 'warning') bg-warning-500 @else bg-info-500 @endif">
                                            {{ ucfirst($alert->severity) }}
                                        </span>
                                    </td>
                                    <td>{{ $alert->alert_type }}</td>
                                    <td>
                                        <span class="badge @if($alert->status == 'resolved') bg-success-500 @else bg-secondary-500 @endif">
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
        </div>

        {{-- Service Schedules (formerly Repair History) --}}
        <div class="col-xxl-12 col-xl-12"> {{-- Using col-xxl-6 to make it share row with Alert History on larger screens --}}
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Service Schedules</h6>
                        {{-- Assuming a route for all service schedules, or to create a new one for this system --}}
                        {{-- <a href="#" class="btn-text text-primary-600">View All</a> --}}
                    </div>
                </div>
                <div class="card-body" style="padding: 0 !important">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th>Scheduled Date</th>
                                <th>Service Type</th>
                                <th>Status</th>
                                <th>Assigned Tech</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($serviceSchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                                    <td>{{ $schedule->service_type }}</td>
                                    <td>
                                        <span class="badge @if($schedule->status == 'completed') bg-success-500 @elseif($schedule->status == 'cancelled') bg-danger-500 @else bg-secondary-500 @endif">
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
    </script>
@endpush
