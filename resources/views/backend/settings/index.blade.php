@extends('backend.layouts.master')
@section('title') {{'Settings'}} @endsection
@section('content')
    @include('backend.partials.alert')
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h4 class="fw-semibold mb-0">Settings</h4>
    </div>

    <div class="row gy-4">
        {{-- Users List Card --}}
        <div class="col-xl-12">
            <div class="card basic-data-table h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="fw-bold text-lg mb-0">Users List</h6>
                        <a href="javascript:void(0)" class="btn bg-dark text-light text-sm btn-sm px-12 py-8 radius-4 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="ri-user-add-line icon text-xl line-height-1"></i>
                            Add User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table bordered-table mb-0" id="usersDataTable" data-page-length='10'>
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Last Login</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-10">
                                        <h6 class="text-md mb-0">{{ $user->name }}</h6>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary-500">{{ $role }}</span>
                                    @empty
                                        <span class="badge bg-secondary-500">No Role</span>
                                    @endforelse
                                </td>
                                <td>{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : 'Never' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="javascript:void(0)" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" data-bs-title="Edit">
                                            <iconify-icon icon="lucide:edit" class="icon"></iconify-icon>
                                        </a>
                                        <a href="javascript:void(0)" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                            <iconify-icon icon="lucide:trash" class="icon"></iconify-icon>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User: {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT') {{-- Use PUT method for update requests --}}
                                                <div class="mb-4">
                                                    <label class="form-label" for="edit_name_{{ $user->id }}">Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="edit_name_{{ $user->id }}" name="name" value="{{ old('name', $user->name) }}" required>
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="edit_email_{{ $user->id }}">Email<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="edit_email_{{ $user->id }}" name="email" value="{{ old('email', $user->email) }}" required>
                                                    @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="edit_role_{{ $user->id }}">Role<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="edit_role_{{ $user->id }}" name="role">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('role')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="edit_password_{{ $user->id }}">New Password (optional)</label>
                                                    <input type="password" class="form-control" id="edit_password_{{ $user->id }}" name="password">
                                                    <small class="form-text text-muted">Leave blank to keep current password.</small>
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="edit_password_confirmation_{{ $user->id }}">Confirm New Password</label>
                                                    <input type="password" class="form-control" id="edit_password_confirmation_{{ $user->id }}" name="password_confirmation">
                                                </div>
                                                <button type="submit" class="btn bg-dark text-light text-md px-24 py-4 radius-4 mt-24">
                                                    Save Changes
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('Delete User') }}</h5>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h5>Are you sure?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <form class="d-inline-block" action="{{ route('users.destroy', $user->id) }}" method="POST">
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

        {{-- API Integrations & Notifications --}}
        <div class="col-xl-12">
            <h5 class="fw-semibold mb-3">API Integrations</h5>
            <div class="d-flex justify-content-between align-items-center">
                {{-- SolarEdge API Card --}}
                <div class="card mb-4" style="width: 32%;">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold text-lg">SolarEdge API</h6>
                    </div>
                    <div class="card-body p-24">
                        <form id="solarEdgeForm" action="{{ route('settings.updateSolarEdge') }}" method="POST">
                            @csrf
                            <div class="mb-20">
                                <label for="solar_edge_api_key" class="form-label">API Key</label>
                                <input type="text" name="solar_edge_api_key" id="solar_edge_api_key" class="form-control"
                                       placeholder="Enter SolarEdge API Key" value="{{ old('solar_edge_api_key', $solarEdgeApiKey->value ?? '') }}">
                                @error('solar_edge_api_key')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20">
                                <label for="solar_edge_site_id" class="form-label">Site ID</label>
                                <input type="text" name="solar_edge_site_id" id="solar_edge_site_id" class="form-control"
                                       placeholder="Enter SolarEdge Site ID" value="{{ old('solar_edge_site_id', $solarEdgeSiteId->value ?? '') }}">
                                @error('solar_edge_site_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" data-api="solaredge" class="btn btn-secondary text-sm px-12 py-8 radius-4 d-flex align-items-center test-connection-btn">
                                    <i class="ri-refresh-line icon text-xl line-height-1 me-2"></i>
                                    Test Connection
                                </button>
                                <button type="submit" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
                                    Save Changes
                                </button>
                            </div>
                            <div id="solarEdgeResult" class="mt-3"></div>
                        </form>
                    </div>
                </div>

                {{-- Housecall API Card --}}
                <div class="card mb-4" style="width: 32%;">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold text-lg">Housecall API</h6>
                    </div>
                    <div class="card-body p-24">
                        <form id="housecallForm" action="{{ route('settings.updateHousecall') }}" method="POST">
                            @csrf
                            <div class="mb-20">
                                <label for="housecall_api_key" class="form-label">API Key</label>
                                <input type="text" name="housecall_api_key" id="housecall_api_key" class="form-control"
                                       placeholder="Enter Housecall API Key" value="{{ old('housecall_api_key', $housecallApiKey->value ?? '') }}">
                                @error('housecall_api_key')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20">
                                <label for="housecall_client_id" class="form-label">Client ID</label>
                                <input type="text" name="housecall_client_id" id="housecall_client_id" class="form-control"
                                       placeholder="Enter Housecall Client ID" value="{{ old('housecall_client_id', $housecallClientId->value ?? '') }}">
                                @error('housecall_client_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" data-api="housecall" class="btn btn-secondary text-sm px-12 py-8 radius-4 d-flex align-items-center test-connection-btn">
                                    <i class="ri-refresh-line icon text-xl line-height-1 me-2"></i>
                                    Test Connection
                                </button>
                                <button type="submit" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
                                    Save Changes
                                </button>
                            </div>
                            <div id="housecallResult" class="mt-3"></div>
                        </form>
                    </div>
                </div>

                {{-- Weather API Card --}}
                <div class="card mb-4" style="width: 32%;">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold text-lg">Weather API</h6>
                    </div>
                    <div class="card-body p-24">
                        <form id="weatherForm" action="{{ route('settings.updateWeather') }}" method="POST">
                            @csrf
                            <div class="mb-20">
                                <label for="weather_api_key" class="form-label">API Key</label>
                                <input type="text" name="weather_api_key" id="weather_api_key" class="form-control"
                                       placeholder="Enter Weather API Key" value="{{ old('weather_api_key', $weatherApiKey->value ?? '') }}">
                                @error('weather_api_key')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20">
                                <label for="weather_api_base_url" class="form-label">Base URL</label>
                                <input type="text" name="weather_api_base_url" id="weather_api_base_url" class="form-control"
                                       placeholder="e.g., https://api.openweathermap.org/data/2.5/" value="{{ old('weather_api_base_url', $weatherApiBaseUrl->value ?? '') }}">
                                @error('weather_api_base_url')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" data-api="weather" class="btn btn-secondary text-sm px-12 py-8 radius-4 d-flex align-items-center test-connection-btn">
                                    <i class="ri-refresh-line icon text-xl line-height-1 me-2"></i>
                                    Test Connection
                                </button>
                                <button type="submit" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
                                    Save Changes
                                </button>
                            </div>
                            <div id="weatherResult" class="mt-3"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications Settings --}}
        <div class="col-xl-12">
            <h5 class="fw-semibold mb-3 mt-4">Notification Preferences</h5>
            <div class="card">
                <div class="card-body p-24">
                    <form action="{{ route('settings.updateNotifications') }}" method="POST">
                        @csrf
                        <div class="mb-24">
                            <h6 class="mb-16 fw-bold text-lg">Email Notifications</h6>
                            <div class="d-flex flex-wrap justify-content-between gap-1">
                                <label class="form-label fw-medium text-secondary-light text-lg mb-8">System Alerts</label>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="On" checked>
                                </div>
                            </div>
                            <span class="text-sm">Receive emails for critical system issues</span>

                            <div class="d-flex flex-wrap justify-content-between gap-1 mt-20">
                                <label class="form-label fw-medium text-secondary-light text-lg mb-8">Daily Reports</label>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="On">
                                </div>
                            </div>
                            <span class="text-sm">Daily summary of system performance</span>

                            <div class="d-flex flex-wrap justify-content-between gap-1 mt-20">
                                <label class="form-label fw-medium text-secondary-light text-lg mb-8">Service Reminders</label>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="On">
                                </div>
                            </div>
                            <span class="text-sm">Notifications about upcoming service appointments</span>
                        </div>

                        <div class="mb-24">
                            <h6 class="mb-16 fw-bold text-lg">SMS Notifications</h6>
                            <div class="d-flex flex-wrap justify-content-between gap-1">
                                <label class="form-label fw-medium text-secondary-light text-lg mb-8">Critical Alerts</label>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="On" checked>
                                </div>
                            </div>
                            <span class="text-sm">Receive text messages for urgent system issues</span>

                            <div class="d-flex flex-wrap justify-content-between gap-1 mt-20">
                                <label class="form-label fw-medium text-secondary-light text-lg mb-8">Service Updates</label>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="On">
                                </div>
                            </div>
                            <span class="text-sm">Text notifications about service status changes</span>
                        </div>

                        <div class="mb-24">
                            <h6 class="mb-16 fw-bold text-lg">In-App Notifications</h6>
                            <div class="d-flex flex-wrap justify-content-between gap-1">
                                <label class="form-label fw-medium text-secondary-light text-lg mb-8">All System Alerts</label>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="On">
                                </div>
                            </div>
                            <span class="text-sm">Show all system alerts in the app</span>

                            <div class="d-flex flex-wrap justify-content-between gap-1 mt-20">
                                <label class="form-label fw-medium text-secondary-light text-lg mb-8">User Activity</label>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="On">
                                </div>
                            </div>
                            <span class="text-sm">Notifications about team member actions</span>
                        </div>

                        <button type="submit" class="btn bg-dark text-light text-sm btn-sm px-8 py-8 radius-4 d-flex align-items-center">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Form action points to UserController@store, which is good practice. --}}
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label" for="name">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="password_confirmation">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="role">Role<span class="text-danger">*</span></label>
                            <select class="form-select" id="role" name="role">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn bg-dark text-light text-md px-24 py-4 radius-4 mt-24">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        new DataTable('#usersDataTable', {
            //scrollX: true
        });

        // Universal Test Connection Script for all APIs
        document.querySelectorAll('.test-connection-btn').forEach(button => {
            button.addEventListener('click', function() {
                const apiType = this.dataset.api; // 'solaredge', 'housecall', 'weather'
                let apiKey, idField, resultDiv, testRoute;

                switch (apiType) {
                    case 'solaredge':
                        apiKey = document.getElementById('solar_edge_api_key').value;
                        idField = document.getElementById('solar_edge_site_id').value;
                        resultDiv = document.getElementById('solarEdgeResult');
                        testRoute = '{{ route('settings.testSolarEdgeConnection') }}';
                        break;
                    case 'housecall':
                        apiKey = document.getElementById('housecall_api_key').value;
                        idField = document.getElementById('housecall_client_id').value;
                        resultDiv = document.getElementById('housecallResult');
                        testRoute = '{{ route('settings.testHousecallConnection') }}';
                        break;
                    case 'weather':
                        apiKey = document.getElementById('weather_api_key').value;
                        idField = document.getElementById('weather_api_base_url').value; // Base URL acts as the second ID here
                        resultDiv = document.getElementById('weatherResult');
                        testRoute = '{{ route('settings.testWeatherConnection') }}';
                        break;
                    default:
                        return; // Should not happen
                }

                resultDiv.innerHTML = '<div class="alert alert-info">Testing connection...</div>';
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                let requestBody = {};
                if (apiType === 'solaredge') {
                    requestBody.solar_edge_api_key = apiKey;
                    requestBody.solar_edge_site_id = idField;
                } else if (apiType === 'housecall') {
                    requestBody.housecall_api_key = apiKey;
                    requestBody.housecall_client_id = idField;
                } else if (apiType === 'weather') {
                    requestBody.weather_api_key = apiKey;
                    requestBody.weather_api_base_url = idField;
                }


                fetch(testRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(requestBody)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            resultDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        } else {
                            resultDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultDiv.innerHTML = '<div class="alert alert-danger">An error occurred while testing connection.</div>';
                    });
            });
        });
    </script>
@endpush
