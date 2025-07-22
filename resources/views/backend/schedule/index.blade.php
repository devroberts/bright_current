@extends('backend.layouts.master')
@section('title') {{'Service Schedules'}} @endsection
@section('content')
    @include('backend.partials.alert')
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h4 class="fw-semibold mb-0">Service Schedule List</h4>
        <a href="{{ route('service-schedules.create') }}" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
            Add New Schedule
        </a>
    </div>

    <div class="row gy-4">
        <div class="col-xl-8">
            <div class="card basic-data-table">
                <div class="card-body">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                        <thead>
                        <tr>
                            <th scope="col">System ID</th>
                            <th scope="col">Scheduled Date</th>
                            <th scope="col">Scheduled Time</th>
                            <th scope="col">Service Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Assigned Technician</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($serviceSchedules as $schedule)
                            <tr>
                                <td>
                                    {{-- Link to system show page --}}
                                    <a href="{{ route('system.show', $schedule->system->id) }}" class="text-primary-600 fw-medium">
                                        {{ $schedule->system->system_id }}
                                    </a>
                                </td>
                                <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                                <td>{{ $schedule->scheduled_time }}</td>
                                <td>{{ $schedule->service_type }}</td>
                                <td>
                            <span class="text-white px-16 py-4 radius-4 fw-medium text-sm @if($schedule->status == 'completed') bg-success @elseif($schedule->status == 'cancelled') bg-danger bg-success @elseif($schedule->status == 'scheduled') bg-info @else bg-warning @endif">
                                {{ ucfirst($schedule->status) }}
                            </span>
                                </td>
                                <td>{{ $schedule->assigned_technician ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('service-schedules.edit', $schedule->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>
                                        <a href="javascript:void(0)" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteScheduleModal{{ $schedule->id }}">
                                            <iconify-icon icon="lucide:trash-2"></iconify-icon>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="deleteScheduleModal{{ $schedule->id }}" tabindex="-1" aria-labelledby="deleteScheduleModalLabel{{ $schedule->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteScheduleModalLabel{{ $schedule->id }}">{{ __('Delete Service Schedule') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h5>Are you sure you want to delete this schedule?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <form class="d-inline-block" action="{{ route('service-schedules.destroy', $schedule->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Yes, delete</button>
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
        {{-- Right Column: Upcoming Jobs --}}
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Upcoming Jobs</h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table mb-0">
                            <tbody>
                            @forelse ($upcomingSchedules as $upcoming)
                                <tr>
                                    <td>
                                        {{-- Link to system show page for details --}}
                                        <a href="{{ route('system.show', $upcoming->system->id) }}" class="text-primary-600 fw-medium">{{ $upcoming->system->system_id }}</a>
                                        <p class="text-sm text-secondary-light mb-0">{{ $upcoming->service_type }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm text-secondary-light mb-0">{{ $upcoming->scheduled_date->format('M d, Y') }}</p>
                                    </td>
                                    <td>
                                        <span class="text-white px-8 radius-4 fw-medium text-sm  bg-secondary ">{{ $upcoming->scheduled_time }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No upcoming jobs.</td>
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
    <script>
        // Initialize DataTable
        let table = new DataTable('#dataTable', {
            scrollX: true
        });
    </script>
@endpush
