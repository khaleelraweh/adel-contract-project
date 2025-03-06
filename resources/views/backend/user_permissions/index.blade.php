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
                        {{ __('panel.show_permissions') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_user_Permissions')
                    <a href="{{ route('admin.user_permissions.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_permission') }}</span>
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
                        <th>{{ __('panel.user') }}</th>
                        <th>{{ __('panel.role_display_name') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('panel.created_at') }}</th>
                        <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($role_users as $role_user)
                        <tr>
                            <td>
                                {{ $role_user->first_name ?? 'N/A' }} <br>
                            </td>
                            <td>
                                @foreach ($role_user->roles as $role)
                                {{ $role->display_name ?? 'N/A' }}
                                @if (!$loop->last)
                                ،
                                @endif
                                @endforeach
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ \Carbon\Carbon::parse($role_user->created_at)->diffForHumans() }}
                            </td>
                            <td>
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
                                                href="{{ route('admin.user_permissions.show', $role_user->id) }}">
                                                <i data-feather="eye" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_show') }}</span>
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('admin.user_permissions.edit', $role_user->id) }}">
                                                <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_edit') }}</span>
                                            </a>

                                            <a href="javascript:void(0);"
                                                onclick="confirmDelete('delete-role_user-{{ $role_user->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')"
                                                class="dropdown-item d-flex align-items-center">
                                                <i data-feather="trash" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_delete') }}</span>
                                            </a>
                                            <form action="{{ route('admin.user_permissions.destroy', $role_user->id) }}"
                                                method="post" class="d-none" id="delete-role_user-{{ $role_user->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <a href="javascript:void(0);"
                                                class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                data-copy-text="https://ibbuniv.era-t.com/role_user-single/{{ $role_user->slug }}"
                                                data-id="{{ $role_user->id }}" title="Copy the link">
                                                <i data-feather="copy" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_copy_link') }}</span>
                                            </a>
                                        </div>
                                        <span class="copyMessage" data-id="{{ $role_user->id }}" style="display:none;">
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
                                {{-- {!! $role_users->appends(request()->all())->links() !!} --}}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
