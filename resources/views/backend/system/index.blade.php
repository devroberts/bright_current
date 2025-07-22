@extends('backend.layouts.master')
@section('title') {{'System List'}} @endsection
@section('content')
    @include('backend.partials.alert')
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h4 class="fw-semibold mb-0">System List</h4>
        <a href="{{ route('system.create') }}" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
            Add New System
        </a>
    </div>

    <div class="row gy-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                        <thead>
                        <tr>
                            <th scope="col">Customer</th>
                            <th scope="col">Manufacturer</th>
                            <th scope="col">System ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">kWH Today</th>
                            <th scope="col">kWH Yesterday</th>
                            <th scope="col">Last Seen</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($systems as $system)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="{{ $system->customer_type === 'residential' ? 'ri-home-3-line' : 'ri-file-list-line' }} text-xxl me-8 d-flex"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="text-md mb-0">{{ $system->customer_name }}</h6>
                                            <span class="text-sm text-secondary-light fw-medium">{{ $system->customer_type }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $system->manufacturer }}</td>
                                <td>{{ $system->system_id }}</td>
                                <td>
                                    @if ($system->status === 'Active')
                                        <span class="bg-success text-white px-16 py-4 radius-4 fw-medium text-sm">{{ $system->status }}</span>
                                    @elseif ($system->status === 'Warning')
                                        <span class="bg-warning text-dark px-16 py-4 radius-4 fw-medium text-sm">{{ $system->status }}</span>
                                    @elseif ($system->status === 'Critical')
                                        <span class="bg-danger text-dark px-16 py-4 radius-4 fw-medium text-sm">{{ $system->status }}</span>
                                    @else
                                        <span class="bg-secondary text-white px-16 py-4 radius-4 fw-medium text-sm">{{ $system->status }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format(rand(0, 100) / 10, 1) }} kWh</td>
                                <td>{{ number_format(rand(0, 100) / 10, 1) }} kWh</td>
                                <td>{{ $system->last_seen ? $system->last_seen->diffForHumans() : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('system.show', $system->id) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    {{-- Corrected Edit Link --}}
                                    <a href="{{ route('system.edit', $system->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a href="javascript:void(0)" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal{{$system->id}}">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="deleteModal{{ $system->id }}" tabindex="-1" role="dialog" aria-hidden="false">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('Delete System') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h5>Are you sure you want to delete this system?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form class="d-inline-block" action="{{ route('system.destroy', $system->id) }}" method="POST">
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
@endsection

@push('script')
    <script>
        let table = new DataTable('#dataTable', {
            //scrollX: true
        });
    </script>
@endpush
