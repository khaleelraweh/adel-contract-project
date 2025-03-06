@extends('layouts.admin')

@section('content')
    {{-- Main holder page --}}
    <div class="card shadow mb-4">

        {{-- Breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <div class="card-naving">
                <h3 class="font-weight-bold mb-0">
                    <i class="fa fa-eye me-2"></i>
                    {{ __('panel.show_user_permissions') }}
                </h3>
                <ul class="breadcrumb pt-3 mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.index') }}" class="text-white">{{ __('panel.main') }}</a>
                    </li>
                    <li class="breadcrumb-item ms-1">
                        <a href="{{ route('admin.user_permissions.index') }}" class="text-white">
                            {{ __('panel.show_user_permissions') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Body part --}}
        <div class="card-body">

            {{-- User Details --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h4 class="font-weight-bold text-primary mb-0">
                                <i class="fa fa-user me-2"></i>
                                {{ __('panel.user_details') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ __('panel.name') }}:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                                    <p><strong>{{ __('panel.email') }}:</strong> {{ $user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>{{ __('panel.username') }}:</strong> {{ $user->username }}</p>
                                    <p><strong>{{ __('panel.status') }}:</strong>
                                        <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Roles and Permissions Section --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h4 class="font-weight-bold text-primary mb-0">
                                <i class="fa fa-shield-alt me-2"></i>
                                {{ __('panel.roles_and_permissions') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            @if ($user->roles->count() > 0)
                                @foreach ($user->roles as $role)
                                    <div class="card mb-3 border-0 shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="font-weight-bold mb-0">
                                                <i class="fa fa-user-tag me-2"></i>
                                                <strong>{{ __('panel.role') }}:</strong> {{ $role->display_name }} ({{ $role->name }})
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="font-weight-bold text-secondary">
                                                <i class="fa fa-key me-2"></i>
                                                {{ __('panel.permissions') }}:
                                            </h6>
                                            @if ($role->permissions->count() > 0)
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($role->permissions as $permission)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span>
                                                                <i class="fa fa-check-circle text-success me-2"></i>
                                                                <strong>{{ $permission->display_name }}</strong> ({{ $permission->name }})
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="alert alert-warning mb-0">
                                                    <i class="fa fa-exclamation-circle me-2"></i>
                                                    {{ __('panel.no_permissions_assigned_to_role') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info mb-0">
                                    <i class="fa fa-info-circle me-2"></i>
                                    {{ __('panel.no_roles_assigned_to_user') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <a href="{{ route('admin.user_permissions.index') }}" class="btn btn-outline-primary">
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
