@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_users') }}
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
                        {{ __('panel.show_user_permissions') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_user_permissions')
                    <a href="{{ route('admin.user_permissions.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_user_permission') }}</span>
                    </a>
                @endability
            </div>

        </div>

        @include('backend.user_permissions.filter.filter')

        <div class="card-body">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">{{ __('panel.image') }}</th>
                        <th>{{ __('panel.advertisor_name') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('panel.email') }} {{ __('panel.and') }}
                            {{ __('panel.mobile') }} </th>
                        <th>{{ __('panel.status') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('panel.created_at') }}</th>
                        <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user_permissions as $user_permission)
                        <tr>
                            <td class="d-none d-sm-table-cell">
                                @php
                                    if ($user_permission->user_image != null) {
                                        $user_permission_img = asset('assets/users/' . $user_permission->user_image);

                                        if (!file_exists(public_path('assets/users/' . $user_permission->user_image))) {
                                            $user_permission_img = asset('image/not_found/avator1.webp');
                                        }
                                    } else {
                                        $user_permission_img = asset('image/not_found/avator1.webp');
                                    }
                                @endphp

                                <img src="{{ $user_permission_img }}" width="60" height="60"
                                    alt="{{ $user_permission->full_name }}">

                            </td>
                            <td>


                                {{ $user_permission->full_name }} <br>
                                <small>
                                    <span class="bg-info px-2 text-white rounded-pill">
                                        {{ __('panel.username') }}:
                                        <strong>{{ $user_permission->username }}</strong>
                                    </span>
                                </small>

                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $user_permission->email }} <br>
                                {{ $user_permission->mobile }}
                            </td>
                            <td>

                                @if ($user_permission->status == 1)
                                    <a href="javascript:void(0);" class="updateuser_permissionstatus "
                                        id="user_permission-{{ $user_permission->id }}"
                                        user_permission_id="{{ $user_permission->id }}">
                                        <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true" status="Active"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="updateuser_permissionstatus"
                                        id="user_permission-{{ $user_permission->id }}"
                                        user_permission_id="{{ $user_permission->id }}">
                                        <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true" status="Inactive"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ \Carbon\Carbon::parse($user_permission->published_on)->diffForHumans() }}
                            </td>
                            <td>
                                {{-- <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.user_permissions.edit', $user_permission->id) }}"
                                        class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                        onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-user_permission-{{ $user_permission->id }}').submit();}else{return false;}"
                                        class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                <form action="{{ route('admin.user_permissions.destroy', $user_permission->id) }}" method="post"
                                    class="d-none" id="delete-user_permission-{{ $user_permission->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                                <div class="btn-group btn-group-sm">
                                    <div class="dropdown mb-2 ">
                                        <a type="button" class="d-flex" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                                            {{ __('panel.operation_options') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                viewBox="0 0 25 15" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-chevron-down link-arrow">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item d-flex align-items-center btn btn-success"
                                                href="{{ route('admin.user_permissions.show', $user_permission->id) }}">
                                                <i data-feather="eye" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_show') }}</span>
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('admin.user_permissions.edit', $user_permission->id) }}">
                                                <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_edit') }}</span>
                                            </a>

                                            <a href="javascript:void(0);"
                                                onclick="confirmDelete('delete-user_permission-{{ $user_permission->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')"
                                                class="dropdown-item d-flex align-items-center">
                                                <i data-feather="trash" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_delete') }}</span>
                                            </a>
                                            <form
                                                action="{{ route('admin.user_permissions.destroy', $user_permission->id) }}"
                                                method="post" class="d-none"
                                                id="delete-user_permission-{{ $user_permission->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <a href="javascript:void(0);"
                                                class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                data-copy-text="https://ibbuniv.era-t.com/user_permission-single/{{ $user_permission->slug }}"
                                                data-id="{{ $user_permission->id }}" title="Copy the link">
                                                <i data-feather="copy" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_copy_link') }}</span>
                                            </a>

                                        </div>
                                        <span class="copyMessage" data-id="{{ $user_permission->id }}"
                                            style="display:none;">
                                            {{ __('panel.copied') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('panel.no_found_item') }}</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $user_permissions->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
@endsection
