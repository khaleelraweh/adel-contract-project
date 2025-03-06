@extends('layouts.admin')

@section('content')
    {{-- Main holder page --}}
    <div class="card shadow mb-4">

        {{-- Breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <div class="card-naving">
                <h3 class="font-weight-bold mb-0">
                    <i class="fa fa-eye me-2"></i>
                    {{ __('panel.show_role_detials') }}
                </h3>
                <ul class="breadcrumb pt-3 mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.index') }}" class="text-white">{{ __('panel.main') }}</a>
                    </li>
                    <li class="breadcrumb-item ms-1">
                        <a href="{{ route('admin.user_groups.index') }}" class="text-white">
                            {{ __('panel.show_roles') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Body part --}}
        <div class="card-body">

            {{-- Role Details --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h4 class="font-weight-bold text-primary mb-0">
                                <i class="fa fa-shield-alt me-2"></i>
                                {{ __('panel.role_details') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ __('panel.name') }}:</strong> {{ $user_group->name }}</p>
                                    <p><strong>{{ __('panel.display_name') }}:</strong> {{ $user_group->display_name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>{{ __('panel.description') }}:</strong> {{ $user_group->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permissions Section --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h4 class="font-weight-bold text-primary mb-0">
                                <i class="fa fa-key me-2"></i>
                                {{ __('panel.associated_permissions') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            @if ($permissions->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach ($permissions as $permission)
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
                                    {{ __('panel.no_permissions_assigned') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <a href="{{ route('admin.user_groups.index') }}" class="btn btn-outline-primary">
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
