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
                            <!-- Name Section -->
                            <div class="mb-4">
                                <label
                                    class="form-label text-muted small mb-1">{{ __('panel.document_template_name') }}</label>
                                <h4 class="fw-bold">{{ $document_template->getTranslation('doc_template_name', 'ar') }}</h4>
                            </div>

                            <!-- Description Section -->
                            <div class="mb-4">
                                <label
                                    class="form-label text-muted small mb-1">{{ __('panel.document_template_text') }}</label>
                                <p class="lead">{!! $document_template->doc_template_text !!}</p>
                            </div>
                        </fieldset>

                        <!-- Status Section -->
                        <div class="mb-4">
                            <label class="form-label text-muted small mb-1">{{ __('panel.status') }}</label>
                            <p>
                                <span class="badge {{ $document_template->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $document_template->status ? __('Active') : __('Inactive') }}
                                </span>
                            </p>
                        </div>

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
