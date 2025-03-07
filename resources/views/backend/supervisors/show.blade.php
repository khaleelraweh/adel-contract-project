@extends('layouts.admin')

@section('content')
    {{-- Main holder page --}}
    <div class="card shadow mb-4">

        {{-- Breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <div class="card-naving">
                <h3 class="font-weight-bold mb-0">
                    <i class="fa fa-eye me-2"></i>
                    {{ __('panel.show_supervisor_details') }}
                </h3>
                <ul class="breadcrumb pt-3 mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.index') }}" class="text-white">{{ __('panel.main') }}</a>
                    </li>
                    <li class="breadcrumb-item ms-1">
                        <a href="{{ route('admin.supervisors.index') }}" class="text-white">
                            {{ __('panel.show_supervisors') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Body part --}}
        <div class="card-body">

            {{-- Supervisor Details --}}
            <div class="row mb-4">
                {{-- Supervisor Image --}}
                <div class="col-sm-12 col-md-4 text-center">
                    <div class="profile-image mb-4">
                        <img src="{{ asset('assets/users/' . $supervisor->user_image) }}" alt="{{ $supervisor->full_name }}"
                            class="img-fluid rounded-circle shadow-sm" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                </div>

                {{-- Supervisor Information --}}
                <div class="col-sm-12 col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h4 class="font-weight-bold text-primary mb-0">
                                <i class="fa fa-user me-2"></i>
                                {{ __('panel.user_information') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('panel.first_name') }}</th>
                                            <td>{{ $supervisor->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.last_name') }}</th>
                                            <td>{{ $supervisor->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.user_name') }}</th>
                                            <td>{{ $supervisor->username }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.email') }}</th>
                                            <td>{{ $supervisor->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.mobile') }}</th>
                                            <td>{{ $supervisor->mobile }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.status') }}</th>
                                            <td>
                                                @if ($supervisor->status == 1)
                                                    <span class="badge bg-success">{{ __('panel.status_active') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __('panel.status_inactive') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.roles') }}</th>
                                            <td>
                                                @if ($supervisor->roles->count() > 0)
                                                    <ul class="list-unstyled">
                                                        @foreach ($supervisor->roles as $role)
                                                            <li>
                                                                    <i class="fa fa-check-circle text-success me-2"></i>
                                                                    {{ $role->display_name }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">{{ __('panel.no_roles_assigned') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.permissions') }}</th>
                                            <td>
                                                @if ($supervisor->permissions->count() > 0)
                                                    <ul class="list-unstyled">
                                                        @foreach ($supervisor->permissions as $permission)
                                                            <li>
                                                                <i class="fa fa-check-circle text-success me-2"></i>
                                                                {{ $permission->display_name }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">{{ __('panel.no_permissions_assigned') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.created_at') }}</th>
                                            <td>{{ $supervisor->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('panel.updated_at') }}</th>
                                            <td>{{ $supervisor->updated_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <a href="{{ route('admin.supervisors.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-left me-2"></i>
                        {{ __('panel.back_to_list') }}
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        // Additional scripts can be added here if needed
    </script>
@endsection
