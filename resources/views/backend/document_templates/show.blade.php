@extends('layouts.admin')

@section('style')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .btn-light:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }

        /* تنسيق fieldset */
        fieldset {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* تنسيق legend */
        legend {
            font-size: 1.2rem;
            font-weight: bold;
            color: #495057;
            background-color: #ffffff;
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: auto;
            margin-left: -10px;
        }

        /* تحسين المسافات داخل fieldset */
        fieldset .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        /* تحسين تنسيق النصوص داخل fieldset */
        fieldset .form-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        fieldset .fw-bold {
            font-size: 1.1rem;
            color: #343a40;
        }

        fieldset .lead {
            font-size: 1rem;
            color: #495057;
            line-height: 1.6;
        }
    </style>
    <style>
        /* تنسيق المستويات الهرمية */
        .document-page {
            border-right: 4px solid #007bff;
            padding-right: 15px;
            margin-bottom: 20px;
        }

        .page-group {
            border-right: 4px solid #28a745;
            padding-right: 15px;
            margin-bottom: 15px;
        }

        .page-variable {
            border-right: 4px solid #dc3545;
            padding-right: 15px;
            margin-bottom: 10px;
        }

        /* تنسيق الرموز */
        .fa-file-alt,
        .fa-folder,
        .fa-tag {
            color: #6c757d;
        }

        /* تحسين المسافات */
        .ms-4 {
            margin-right: 1.5rem !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('panel.document_template_details') }}</h3>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        <!-- Basic Info Section -->
                        <fieldset>
                            <legend>{{ __('panel.document_template_basic_info') }}</legend>
                            <!-- document template category  name-->
                            <div class="mb-4">
                                <label class="form-label text-muted small mb-1">
                                    {{ __('panel.document_category_name') }}
                                </label>
                                <h4 class="fw-bold">
                                    {{ $document_template->documentType->documentCategory->getTranslation('doc_cat_name', 'ar') }}
                                </h4>
                            </div>
                            <!-- Document Template Type name-->
                            <div class="mb-4">
                                <label class="form-label text-muted small mb-1">
                                    {{ __('panel.document_type_name') }}
                                </label>
                                <h4 class="fw-bold">
                                    {{ $document_template->documentType->getTranslation('doc_type_name', 'ar') }}</h4>
                            </div>

                            <!-- Document Template name -->
                            <div class="mb-4">
                                <label class="form-label text-muted small mb-1">
                                    {{ __('panel.document_template_name') }}
                                </label>
                                <h4 class="fw-bold">{{ $document_template->getTranslation('doc_template_name', 'ar') }}</h4>
                            </div>
                            <!-- Document Template Language -->
                            <div class="mb-4">
                                <label class="form-label text-muted small mb-1">
                                    {{ __('panel.language') }}
                                </label>
                                <h4 class="fw-bold">{{ $document_template->language() }}</h4>
                            </div>

                            <!-- Document Template Status -->
                            <div class="mb-4">
                                <label class="form-label text-muted small mb-1">
                                    {{ __('panel.status') }}
                                </label>
                                <p>
                                    <span class="badge {{ $document_template->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $document_template->status ? __('Active') : __('Inactive') }}
                                    </span>
                                </p>
                            </div>

                        </fieldset>



                        <!-- Document Template Pages and Variables -->
                        <fieldset>
                            <legend>{{ __('panel.document_template_pages_and_variables') }}</legend>

                            @forelse ($document_template->documentPages as $documentPage)
                                <div class="mb-4">
                                    <!-- Document Page Name -->
                                    <div class="document-page">
                                        <label class="form-label text-muted small mb-1">
                                            {{ __('panel.document_page_name') }}
                                        </label>
                                        <h4 class="fw-bold">
                                            <i class="fas fa-file-alt me-2"></i> {{ $documentPage->doc_page_name }}
                                        </h4>
                                    </div>

                                    @forelse ($documentPage->pageGroups as $pageGroup)
                                        <!-- Page Group Name -->
                                        <div class="page-group ms-4">
                                            <label class="form-label text-muted small mb-1">
                                                {{ __('panel.document_page_group_name') }}
                                            </label>
                                            <h4 class="fw-bold">
                                                <i class="fas fa-folder me-2"></i> {{ $pageGroup->pg_name }}
                                            </h4>

                                            <div class="mb-3"></div>

                                            @forelse ($pageGroup->pageVariables as $pageVariable)
                                                <!-- Page Variable Info -->

                                                <div class="page-variable ms-4 mb-4">
                                                    <h5 class="form-label text-muted small mb-1 ">
                                                        {{ __('panel.document_page_group_variable_info') }}
                                                    </h5>

                                                    <label class="form-label text-muted small mb-1">
                                                        {{ __('panel.pv_name') }}
                                                    </label>
                                                    <h4 class="fw-bold mb-3">
                                                        <i class="fas fa-tag me-2"></i> {{ $pageVariable->pv_name }}
                                                    </h4>

                                                    <label class="form-label text-muted small mb-1">
                                                        {{ __('panel.pv_question') }}
                                                    </label>
                                                    <h4 class="fw-bold mb-3">
                                                        <i class="fas fa-tag me-2"></i> {{ $pageVariable->pv_question }}
                                                    </h4>

                                                    <label class="form-label text-muted small mb-1">
                                                        {{ __('panel.pv_type') }}
                                                    </label>
                                                    <h4 class="fw-bold mb-3">
                                                        <i class="fas fa-tag me-2"></i> {{ $pageVariable->pv_type() }}
                                                    </h4>

                                                    <label class="form-label text-muted small mb-1">
                                                        {{ __('panel.pv_required') }}
                                                    </label>
                                                    <h4 class="fw-bold mb-3">
                                                        <i class="fas fa-tag me-2"></i> {{ $pageVariable->pv_required() }}
                                                    </h4>

                                                    <label class="form-label text-muted small mb-1">
                                                        {{ __('panel.pv_details') }}
                                                    </label>
                                                    <h4 class="fw-bold mb-3">
                                                        <i class="fas fa-tag me-2"></i> {{ $pageVariable->pv_details }}
                                                    </h4>

                                                </div>

                                            @empty
                                                <p class="text-muted ms-4">{{ __('panel.no_variables_found') }}</p>
                                            @endforelse
                                        </div>
                                    @empty
                                        <p class="text-muted ms-4">{{ __('panel.no_groups_found') }}</p>
                                    @endforelse
                                </div>
                            @empty
                                <p class="text-muted">{{ __('panel.no_pages_found') }}</p>
                            @endforelse
                        </fieldset>


                        <!-- Document Template Pages and Variables -->
                        <fieldset>
                            <legend>{{ __('panel.document_template_text') }}</legend>
                            <div class="mb-4">
                                <label class="form-label text-muted small mb-1">
                                    {{ __('panel.document_template_text') }}
                                </label>
                                <p class="lead">{!! $document_template->doc_template_text !!}</p>
                            </div>
                        </fieldset>

                        <!-- Timestamps Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">{{ __('panel.published_on') }}</label>
                                <p class="fw-semibold">{{ $document_template->published_on }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">{{ __('panel.updated_at') }}</label>
                                <p class="fw-semibold">{{ $document_template->updated_at }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light d-flex justify-content-end">
                        <a href="{{ route('admin.document_templates.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('panel.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
