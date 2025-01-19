@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_contract_templates') }}
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
                        {{ __('panel.show_contract_templates') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_contract_templates')
                    <a href="{{ route('admin.contract_templates.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50 d-none d-sm-inline-block">
                            <i class="fa fa-plus-square">

                            </i>
                        </span>
                        <span class="text">{{ __('panel.add_new_content') }}</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.contract_templates.filter.filter')

        <div class="card-body">

            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="wd-5p border-bottom-0">#</th>
                        <th class="wd-40p border-bottom-0">{{ __('panel.contract_template_name') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.author') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.status') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.published_on') }}</th>
                        <th class="text-center border-bottom-0" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>


                <tbody>
                    @forelse ($contract_templates as $contract_template)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="checkfilter"
                                    value="{{ $contract_template->id }}">
                            </td>
                            <td>
                                {{ $contract_template->contract_template_name }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $contract_template->created_by }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                @if ($contract_template->status == 1)
                                    <a href="javascript:void(0);" class="updateContractTemplateStatus "
                                        id="contract-template-{{ $contract_template->id }}"
                                        contract_template_id="{{ $contract_template->id }}">
                                        <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true" status="Active"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="updateContractTemplateStatus"
                                        id="contract-template-{{ $contract_template->id }}"
                                        contract_template_id="{{ $contract_template->id }}">
                                        <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true" status="Inactive"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ \Carbon\Carbon::parse($contract_template->published_on)->diffForHumans() }}
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
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('admin.contract_templates.edit', $contract_template->id) }}">
                                                <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_edit') }}</span>
                                            </a>

                                            @if ($contract_template)
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center"
                                                    onclick="showAlert(
                                                        'warning', 
                                                        '{{ __('panel.contract_template_can_not_be_deleted') }}', 
                                                        '{{ __('panel.contract_template_have_contracts_you_must_delete_contracts_related_to_this_contract_template_before') }}', 
                                                        '{{ __('panel.ok') }}'
                                                    )">
                                                    <i data-feather="alert-circle" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center"
                                                    onclick="confirmDelete('delete-contract-template-{{ $contract_template->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')">
                                                    <i data-feather="trash" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                                <form
                                                    action="{{ route('admin.contract_templates.destroy', $contract_template->id) }}"
                                                    method="post" class="d-none"
                                                    id="delete-contract-template-{{ $contract_template->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif

                                            <a href="javascript:void(0);"
                                                class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                data-copy-text="https://ibbuniv.era-t.com/contract_categories/{{ $contract_template->slug }}"
                                                data-id="{{ $contract_template->id }}" title="Copy the link">
                                                <i data-feather="copy" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_copy_link') }}</span>
                                            </a>
                                        </div>
                                        <span class="copyMessage" data-id="{{ $contract_template->id }}"
                                            style="display:none;">
                                            {{ __('panel.copied') }}
                                        </span>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">{{ __('panel.no_found_item') }}</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

@endsection
