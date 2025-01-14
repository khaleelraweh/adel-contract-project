@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_document_types') }}
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
                        {{ __('panel.show_document_types') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_types')
                    <a href="{{ route('admin.document_types.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_content') }}</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.document_types.filter.filter')

        <div class="card-body">

            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="wd-5p border-bottom-0">#</th>
                        <th class="wd-40p border-bottom-0">{{ __('panel.title') }}</th>
                        <th class="d-none d-sm-table-cell wd-15p border-bottom-0">{{ __('panel.author') }}</th>
                        <th class="d-none d-sm-table-cell wd-15p border-bottom-0">{{ __('panel.status') }}</th>
                        <th class="d-none d-sm-table-cell wd-15p border-bottom-0">{{ __('panel.published_on') }}</th>
                        <th class="text-center border-bottom-0" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($document_types as $document_type)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="checkfilter"
                                    value="{{ $document_type->id }}">
                            </td>
                            <td>
                                {{ $document_type->doc_type_name }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $document_type->created_by }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                @if ($document_type->status == 1)
                                    <a href="javascript:void(0);" class="updateDocumentTypeStatus "
                                        id="document-type-{{ $document_type->id }}"
                                        document_type_id="{{ $document_type->id }}">
                                        <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true" status="Active"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="updateDocumentTypeStatus"
                                        id="document-type-{{ $document_type->id }}"
                                        document_type_id="{{ $document_type->id }}">
                                        <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true" status="Inactive"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ \Carbon\Carbon::parse($document_type->published_on)->diffForHumans() }}
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
                                                href="{{ route('admin.document_types.show', $document_type->id) }}">
                                                <i data-feather="eye" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_show') }}</span>
                                            </a>

                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('admin.document_types.edit', $document_type->id) }}">
                                                <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_edit') }}</span>
                                            </a>


                                            @if ($document_type->documentTemplates->count() > 0)
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center"
                                                    onclick="showAlert(
                                                    'warning', 
                                                    '{{ __('panel.document_type_can_not_be_deleted') }}', 
                                                    '{{ __('panel.document_type_have_document_templates_you_must_delete_document_templates_related_to_this_document_type_before') }}', 
                                                    '{{ __('panel.ok') }}'
                                                )">
                                                    <i data-feather="alert-circle" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center"
                                                    onclick="confirmDelete('delete-document-type-{{ $document_type->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')">
                                                    <i data-feather="trash" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                                <form
                                                    action="{{ route('admin.document_types.destroy', $document_type->id) }}"
                                                    method="post" class="d-none"
                                                    id="delete-document-type-{{ $document_type->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif

                                            <a href="javascript:void(0);"
                                                class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                data-copy-text="{{ config('app.url') }}/admin/document_types/{{ $document_type->id }}"
                                                data-id="{{ $document_type->id }}" title="Copy the link">
                                                <i data-feather="copy" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_copy_link') }}</span>
                                            </a>

                                        </div>
                                        <span class="copyMessage" data-id="{{ $document_type->id }}"
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
            </table>
        </div>

    </div>

@endsection
