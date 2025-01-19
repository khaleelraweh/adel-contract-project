@extends('layouts.admin')

@section('content')
    {{-- Main holder page --}}
    <div class="card shadow mb-4">

        {{-- Breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-eye"></i>
                    {{ __('panel.show_supervisor_details') }}
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
                        <a href="{{ route('admin.supervisors.index') }}">
                            {{ __('panel.show_supervisors') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Body part --}}
        <div class="card-body">

            {{-- Supervisor Details --}}
            <div class="row">
                {{-- Supervisor Image --}}
                <div class="col-sm-12 col-md-4 text-center">
                    <div class="profile-image">
                        <img src="{{ asset('assets/users/' . $supervisor->user_image) }}" alt="{{ $supervisor->full_name }}"
                            class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                </div>

                {{-- Supervisor Information --}}
                <div class="col-sm-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                    <th>{{ __('panel.permissions') }}</th>
                                    <td>
                                        @if ($supervisor->permissions->count() > 0)
                                            <ul class="list-unstyled">
                                                @foreach ($supervisor->permissions as $permission)
                                                    <li>{{ $permission->display_name }}</li>
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

            {{-- Back Button --}}
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <a href="{{ route('admin.supervisors.index') }}" class="btn btn-outline-secondary">
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
