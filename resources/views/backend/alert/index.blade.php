@extends('backend.layouts.master')
@section('title') {{'Alert List'}} @endsection
@section('content')
    @include('backend.partials.alert')

    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h4 class="fw-semibold mb-0">Alert List</h4>
        <a href="{{ route('alert.create') }}" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
            Add New Alert
        </a>
    </div>

    {{-- START: Alerts Summary Cards --}}
    <div class="row g-4 mb-24">
        {{-- Card 1: Total Alerts --}}
        <div class="col-xxl-3 col-sm-6">
            <div class="card stat-card style-1">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-body fw-medium mb-8">Total Alerts</p>
                            <h4 class="text-dark fw-bold mb-0">{{ $totalAlerts }}</h4>
                        </div>
                        <div class="icon-box-48 bg-primary-100 text-primary-600 radius-8">
                            <iconify-icon icon="solar:bell-bing-bold"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Card 2: Critical Alerts --}}
        <div class="col-xxl-3 col-sm-6">
            <div class="card stat-card style-1">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-body fw-medium mb-8">Critical Alerts</p>
                            <h4 class="text-danger-600 fw-bold mb-0">{{ $criticalAlerts }}</h4>
                        </div>
                        <div class="icon-box-48 bg-danger-100 text-danger-600 radius-8">
                            <iconify-icon icon="solar:danger-bold"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Card 3: Warning Alerts --}}
        <div class="col-xxl-3 col-sm-6">
            <div class="card stat-card style-1">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-body fw-medium mb-8">Warning Alerts</p>
                            <h4 class="text-warning-600 fw-bold mb-0">{{ $warningAlerts }}</h4>
                        </div>
                        <div class="icon-box-48 bg-warning-100 text-warning-600 radius-8">
                            <iconify-icon icon="solar:warning-circle-bold"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Card 4: Resolved Alerts --}}
        <div class="col-xxl-3 col-sm-6">
            <div class="card stat-card style-1">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-body fw-medium mb-8">Resolved Alerts</p>
                            <h4 class="text-success-600 fw-bold mb-0">{{ $resolvedAlerts }}</h4>
                        </div>
                        <div class="icon-box-48 bg-success-100 text-success-600 radius-8">
                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Alerts Summary Cards --}}

    {{-- START: Filtering System --}}
    <div class="card mb-24">
        <div class="card-body">
            <h6 class="mb-16">Filter Alerts</h6>
            <form action="{{ route('alert.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col">
                        <label for="system_keyword" class="form-label">System ID/Customer</label>
                        <input type="text" class="form-control" id="system_keyword" name="system_keyword" placeholder="Search by System ID or Customer Name" value="{{ request('system_keyword') }}">
                    </div>
                    <div class="col">
                        <label for="severity" class="form-label">Severity</label>
                        <select class="form-select" id="severity" name="severity">
                            <option value="">All Severities</option>
                            <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                            <option value="warning" {{ request('severity') == 'warning' ? 'selected' : '' }}>Warning</option>
                            <option value="info" {{ request('severity') == 'info' ? 'selected' : '' }}>Info</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="col">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary-600 px-24 py-8 radius-8">Filter</button>
                        <a href="{{ route('alert.index') }}" class="btn btn-outline-secondary px-24 py-8 radius-8 ms-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END: Filtering System --}}


    <div class="row gy-4">
        <div class="col-12">
            <div class="card basic-data-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                            <thead>
                            <tr>
                                <th scope="col">Severity</th>
                                <th scope="col">Alert Type</th>
                                <th scope="col">System ID</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($alerts as $alert)
                                <tr>
                                    <td>
                                        @if ($alert->severity === 'critical')
                                            <span class="bg-danger text-white px-16 py-4 radius-4 fw-medium text-sm">Critical</span>
                                        @elseif ($alert->severity === 'warning')
                                            <span class="bg-warning text-dark px-16 py-4 radius-4 fw-medium text-sm">Warning</span>
                                        @else
                                            <span class="bg-info text-white px-16 py-4 radius-4 fw-medium text-sm">Info</span>
                                        @endif
                                    </td>
                                    <td>{{ $alert->alert_type }}</td>
                                    <td>{{ $alert->system->system_id ?? 'N/A' }}</td>
                                    <td>{{ $alert->system->customer_name ?? 'System Deleted' }}</td>
                                    <td>{{ $alert->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        @if ($alert->status === 'resolved')
                                            <span class="bg-success text-white px-16 py-4 radius-4 fw-medium text-sm">{{ ucfirst(str_replace('_', ' ', $alert->status)) }}</span>
                                        @elseif ($alert->status === 'pending')
                                            <span class="bg-warning text-dark px-16 py-4 radius-4 fw-medium text-sm">{{ ucfirst(str_replace('_', ' ', $alert->status)) }}</span>
                                        @elseif ($alert->status === 'in_progress')
                                            <span class="bg-info text-white px-16 py-4 radius-4 fw-medium text-sm">{{ ucfirst(str_replace('_', ' ', $alert->status)) }}</span>
                                        @else {{-- For 'scheduled' and any other default status --}}
                                        <span class="bg-secondary text-white px-16 py-4 radius-4 fw-medium text-sm">{{ ucfirst(str_replace('_', ' ', $alert->status)) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="{{ route('alert.show', $alert->id) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                                <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                            </a>
                                            <a href="{{ route('alert.edit', $alert->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                <iconify-icon icon="lucide:edit"></iconify-icon>
                                            </a>
                                            <a href="javascript:void(0)" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteAlertModal{{ $alert->id }}">
                                                <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="deleteAlertModal{{ $alert->id }}" tabindex="-1" role="dialog" aria-hidden="false">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('Delete Alert') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h5>Are you sure you want to delete this alert?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form class="d-inline-block" action="{{ route('alert.destroy', $alert->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Yes, delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- START: Alert Frequency Chart --}}
    <div class="row gy-4 mt-24">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Alert Trends (Alert Frequency)</h6>
                        <ul class="nav nav-pills-simple nav-pills-simple-sm" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-30-days-tab" data-bs-toggle="pill" data-bs-target="#pills-30-days" type="button" role="tab" aria-controls="pills-30-days" aria-selected="true">30 Days</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-90-days-tab" data-bs-toggle="pill" data-bs-target="#pills-90-days" type="button" role="tab" aria-controls="pills-90-days" aria-selected="false">90 Days</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-1-year-tab" data-bs-toggle="pill" data-bs-target="#pills-1-year" type="button" role="tab" aria-controls="pills-1-year" aria-selected="false">1 Year</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-30-days" role="tabpanel" aria-labelledby="pills-30-days-tab" tabindex="0">
                            <div id="alertFrequencyChart"></div>
                        </div>
                        {{-- Placeholder for 90 days and 1 year tabs --}}
                        <div class="tab-pane fade" id="pills-90-days" role="tabpanel" aria-labelledby="pills-90-days-tab" tabindex="0">
                            <p class="text-secondary-light">Data for 90 days will appear here. (Requires AJAX implementation)</p>
                        </div>
                        <div class="tab-pane fade" id="pills-1-year" role="tabpanel" aria-labelledby="pills-1-year-tab" tabindex="0">
                            <p class="text-secondary-light">Data for 1 year will appear here. (Requires AJAX implementation)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Alert Frequency Chart --}}


@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            // Initialize main DataTable
            $('#dataTable').DataTable({
                //scrollX: true
            });

            // ApexCharts for Alert Frequency (Multiple Lines - Critical, Warning, Info, Resolved)
            var options = {
                series: [{
                    name: 'Critical Alerts',
                    data: @json($criticalAlertData)
                }, {
                    name: 'Warning Alerts',
                    data: @json($warningAlertData)
                }, {
                    name: 'Info Alerts',
                    data: @json($infoAlertData)
                }, {
                    name: 'Resolved Alerts',
                    data: @json($resolvedAlertData)
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
                    categories: @json($alertFrequencyLabels),
                    labels: {
                        style: {
                            colors: '#A0AEC0',
                        },
                    },
                },
                yaxis: {
                    title: {
                        text: 'Number of Alerts'
                    },
                    labels: {
                        formatter: function (value) {
                            return parseInt(value);
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
                },
                grid: {
                    borderColor: '#f1f1f1',
                },
                // Colors: Critical (Danger), Warning, Info, Resolved (Success)
                colors: ['#EE3D5B', '#F7941C', '#17A2B8', '#0D9863']
            };

            var chart = new ApexCharts(document.querySelector("#alertFrequencyChart"), options);
            chart.render();
        });
    </script>
@endpush
