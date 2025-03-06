@extends('layouts.admin')

@section('content')
    {{-- Main holder page --}}
    <div class="card shadow mb-4">

        {{-- Breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-eye"></i>
                    {{ __('panel.show_user_permissions') }}
                </h3>
                <ul class="breadcrumb pt-3">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            /
                        @else
                            \
                        @endif
                    </li>
                    <li class="ms-1">
                        <a href="{{ route('admin.user_permissions.index') }}">
                            {{ __('panel.show_user_permissions') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Body part --}}
        <div class="card-body">

            {{-- User Details --}}
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('panel.user_details') }}</h4>
                    <p><strong>{{ __('panel.name') }}:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                    <p><strong>{{ __('panel.email') }}:</strong> {{ $user->email }}</p>
                    <p><strong>{{ __('panel.username') }}:</strong> {{ $user->username }}</p>
                    <p><strong>{{ __('panel.status') }}:</strong> {{ $user->status == 1 ? 'Active' : 'Inactive' }}</p>
                </div>
            </div>

            {{-- Roles and Permissions Section --}}
            <div class="row mt-4">
                <div class="col-12">
                    <h4>{{ __('panel.roles_and_permissions') }}</h4>
                    @if ($user->roles->count() > 0)
                        @foreach ($user->roles as $role)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <strong>{{ __('panel.role') }}:</strong> {{ $role->display_name }} ({{ $role->name }})
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <h6>{{ __('panel.permissions') }}:</h6>
                                    @if ($role->permissions->count() > 0)
                                        <ul>
                                            @foreach ($role->permissions as $permission)
                                                <li>
                                                    <strong>{{ $permission->display_name }}</strong> ({{ $permission->name }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>{{ __('panel.no_permissions_assigned_to_role') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>{{ __('panel.no_roles_assigned_to_user') }}</p>
                    @endif
                </div>
            </div>

            {{-- Back Button --}}
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <a href="{{ route('admin.user_permissions.index') }}" class="btn btn-outline-secondary">
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
