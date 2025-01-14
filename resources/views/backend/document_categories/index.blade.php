@extends('layouts.admin')

@section('style')
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .page-wrapper {
            position: relative;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: absolute;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }

        @keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }

        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }

        .modal-body {
            padding: 2px 16px;
        }

        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }
    </style>
@endsection

@section('content')

    <!-- Trigger/Open The Modal -->
    <button id="myBtn">Open Modal</button>

    <?php
    if (isset($_GET['show'])) {
        $document_category_id = $_GET['show'];
        echo $document_category_id;
    }
    ?>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Modal Header</h2>
            </div>
            <div class="modal-body">
                <p>Some text in the Modal Body</p>
                <p>Some other text...</p>
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>

    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <div class="card shadow mb-4">

        {{-- breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_document_categories') }}
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
                        {{ __('panel.show_document_categories') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_document_categories')
                    <a href="{{ route('admin.document_categories.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50 d-none d-sm-inline-block">
                            <i class="fa fa-plus-square">

                            </i>
                        </span>
                        <span class="text">{{ __('panel.add_new_content') }}</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.document_categories.filter.filter')




        <div class="card-body">



            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="wd-5p border-bottom-0">#</th>
                        <th class="wd-40p border-bottom-0">{{ __('panel.name') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.author') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.status') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.published_on') }}</th>
                        <th class="text-center border-bottom-0" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>


                <tbody>
                    @forelse ($document_categories as $document_category)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="checkfilter"
                                    value="{{ $document_category->id }}">
                            </td>
                            <td>
                                {{ $document_category->doc_cat_name }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $document_category->created_by }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                @if ($document_category->status == 1)
                                    <a href="javascript:void(0);" class="updateDocumentCategoryStatus "
                                        id="document-category-{{ $document_category->id }}"
                                        document_category_id="{{ $document_category->id }}">
                                        <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true" status="Active"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="updateDocumentCategoryStatus"
                                        id="document-category-{{ $document_category->id }}"
                                        document_category_id="{{ $document_category->id }}">
                                        <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true" status="Inactive"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ \Carbon\Carbon::parse($document_category->published_on)->diffForHumans() }}
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
                                                href="{{ route('admin.document_categories.edit', $document_category->id) }}">
                                                <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_edit') }}</span>
                                            </a>

                                            {{-- <a class="dropdown-item d-flex align-items-center btn btn-success"
                                                href="{{ route('admin.document_categories.show', $document_category->id) }}">
                                                <i data-feather="eye" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_show') }}</span>
                                            </a> --}}
                                            <a class="dropdown-item d-flex align-items-center btn btn-success"
                                                href="document_categories?show=<?php echo $document_category->id; ?>">
                                                <i data-feather="eye" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_show') }}</span>
                                            </a>


                                            @if ($document_category->documentTypes->count() > 0)
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center"
                                                    onclick="showAlert(
                                                        'warning', 
                                                        '{{ __('panel.document_category_can_not_be_deleted') }}', 
                                                        '{{ __('panel.document_category_have_pages_you_must_delete_pages_before') }}', 
                                                        '{{ __('panel.ok') }}'
                                                    )">
                                                    <i data-feather="alert-circle" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center"
                                                    onclick="confirmDelete('delete-document-category-{{ $document_category->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')">
                                                    <i data-feather="trash" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                                <form
                                                    action="{{ route('admin.document_categories.destroy', $document_category->id) }}"
                                                    method="post" class="d-none"
                                                    id="delete-document-category-{{ $document_category->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif

                                            <a href="javascript:void(0);"
                                                class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                data-copy-text="admin/document_categories/{{ $document_category->slug }}"
                                                data-id="{{ $document_category->id }}" title="Copy the link">
                                                <i data-feather="copy" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_copy_link') }}</span>
                                            </a>
                                        </div>
                                        <span class="copyMessage" data-id="{{ $document_category->id }}"
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
