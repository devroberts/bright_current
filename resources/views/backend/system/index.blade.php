@extends('backend.layouts.master')
@section('title') {{'System List'}} @endsection
@section('content')
    @include('backend.partials.alert')
    <div class="page-header d-flex justify-content-end gap-3 mb-24">
        <a href="{{ route('system.create') }}" class="btn bg-dark text-light text-sm btn-sm py-8 radius-4 d-flex align-items-center" style="padding-left: 21px; padding-right: 12px;">
            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
            Add New System
        </a>
    </div>

    <div class="row gy-4">
        <div class="col-12">
            <div class="card basic-data-table">
                <div class="card-body" style="padding: 0 !important;">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10' style="border: 1px solid #707EAE; width: 100% !important; min-width: auto !important;">
                        <thead>
                        <tr>
                            <th scope="col" style="
  padding: 16px 16px 16px 34px !important;">Customer</th>
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
                                <td style="
  padding: 16px 16px 16px 27px !important;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="{{ $system->customer_type === 'Residential' ? 'ri-home-3-line' : 'ri-file-list-line' }} text-xl me-8 d-flex w-32-px h-32-px bg-primary-light rounded-circle d-inline-flex align-items-center justify-content-center"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="text-md mb-0 strong">{{ $system->customer_name }}</h6>
                                            <span class="text-sm text-primary-semi-light fw-medium">{{ $system->customer_type }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $system->manufacturer }}</td>
                                <td>{{ $system->system_id }}</td>
                                <td>
                                    @if ($system->status === 'Active')
                                        <span class="bg-success text-white px-16 py-4 radius-12 fw-bold text-sm">{{ $system->status }}</span>
                                    @elseif ($system->status === 'Warning')
                                        <span class="bg-red text-white px-16 py-4 radius-12 fw-bold text-sm">{{ $system->status }}</span>
                                    @elseif ($system->status === 'Critical')
                                        <span class="bg-red text-white px-16 py-4 radius-12 fw-bold text-sm">{{ $system->status }}</span>
                                    @else
                                        <span class="bg-yellow text-black px-16 py-4 radius-12 fw-bold text-sm">{{ $system->status }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format(rand(0, 100) / 10, 1) }} kWh</td>
                                <td>{{ number_format(rand(0, 100) / 10, 1) }} kWh</td>
                                <td>{{ $system->last_seen ? $system->last_seen->diffForHumans() : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('system.show', $system->id) }}" class="strong text-xxl text-primary-light">
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    {{-- Corrected Edit Link --}}
                                    <a href="{{ route('system.edit', $system->id) }}" class="strong text-xxl text-primary-light">
                                        <iconify-icon icon="solar:logout-2-outline"></iconify-icon>
                                    </a>
                                    <a href="javascript:void(0)" class="strong text-xxl text-primary-light" data-bs-toggle="modal" data-bs-target="#deleteModal{{$system->id}}">
                                        <iconify-icon icon="iconamoon:menu-kebab-vertical-bold"></iconify-icon>
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
