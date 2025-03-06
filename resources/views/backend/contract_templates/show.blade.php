@extends('layouts.admin')

@section('style')
    <style>
        /* General Card Styling */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Badge Styling */
        .badge {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }

        /* Button Styling */
        .btn-light {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
            transform: translateY(-2px);
        }

        /* Fieldset Styling */
        fieldset {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Legend Styling */
        legend {
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
            background-color: #ffffff;
            padding: 10px 20px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: auto;
            margin-left: -10px;
        }

        /* Text and Label Styling */
        .form-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }

        .fw-bold {
            font-size: 1.1rem;
            color: #343a40;
        }

        .lead {
            font-size: 1rem;
            color: #495057;
            line-height: 1.6;
        }

        /* Hierarchical Styling */
        .document-page {
            border-left: 4px solid #007bff;
            padding-left: 15px;
            margin-bottom: 20px;
        }

        .page-group {
            border-left: 4px solid #28a745;
            padding-left: 15px;
            margin-bottom: 15px;
        }

        .page-variable {
            border-left: 4px solid #dc3545;
            padding-left: 15px;
            margin-bottom: 10px;
        }

        /* Icon Styling */
        .fa-file-alt,
        .fa-folder,
        .fa-tag {
            color: #6c757d;
            transition: color 0.3s ease;
        }

        .fa-file-alt:hover,
        .fa-folder:hover,
        .fa-tag:hover {
            color: #007bff;
        }

        /* Spacing and Layout */
        .ms-4 {
            margin-left: 1.5rem !important;
        }

        .card-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #ffffff;
            border-bottom: none;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        /* Hover Effects for Links */
        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 rounded-lg">
                    <!-- Card Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('panel.contract_template_details') }}</h3>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        <!-- Basic Info Section -->
                        <fieldset>
                            <legend>{{ __('panel.contract_template_basic_info') }}</legend>

                            <!-- Document Template Name -->
                            <div class="mb-4">
                                <label class="form-label">{{ __('panel.contract_template_name') }}</label>
                                <h4 class="fw-bold">{{ $contract_template->getTranslation('contract_template_name', 'ar') }}</h4>
                            </div>

                            <!-- Contract Template Language -->
                            <div class="mb-4">
                                <label class="form-label">{{ __('panel.language') }}</label>
                                <h4 class="fw-bold">{{ $contract_template->language() }}</h4>
                            </div>

                            <!-- Contract Template Status -->
                            <div class="mb-4">
                                <label class="form-label">{{ __('panel.status') }}</label>
                                <p>
                                    <span class="badge {{ $contract_template->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $contract_template->status ? __('Active') : __('Inactive') }}
                                    </span>
                                </p>
                            </div>
                        </fieldset>

                        <!-- Contract Template Variables -->
                        <fieldset>
                            <legend>{{ __('panel.contract_template_variables') }}</legend>

                            @forelse ($contract_template->contractVariables as $contractVariable)
                                <div class="mb-4">
                                    <div class="document-page">
                                        <label class="form-label">{{ __('panel.cv_name') }}</label>
                                        <h4 class="fw-bold">
                                            <i class="fas fa-file-alt me-2"></i> {{ $contractVariable->cv_name }}
                                        </h4>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">{{ __('panel.contracts_variales_not_found') }}</p>
                            @endforelse
                        </fieldset>

                        <!-- Contract Template Text -->
                        <fieldset>
                            <legend>{{ __('panel.contract_template_text') }}</legend>
                            <div class="mb-4">
                                <label class="form-label">{{ __('panel.contract_template_text') }}</label>
                                <p class="lead">{!! $contract_template->contract_template_text !!}</p>
                            </div>
                        </fieldset>

                        <!-- Contract Template Contracts -->
                        <fieldset>
                            <legend>{{ __('panel.contract_template_contracts') }}</legend>
                            @forelse ($contract_template->contracts as $contract)
                                <div class="mb-2">
                                    <p class="lead">
                                        <a href="">
                                            <i class="fas fa-file-alt me-2"></i>
                                            {{ $contract->getTranslation('contract_name', 'ar') }}
                                        </a>
                                    </p>
                                </div>
                            @empty
                                <p class="text-muted">{{ __('panel.no_contracts_found') }}</p>
                            @endforelse
                        </fieldset>

                        <!-- Timestamps Section -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('panel.published_on') }}</label>
                                <p class="fw-semibold">{{ $contract_template->published_on }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('panel.updated_at') }}</label>
                                <p class="fw-semibold">{{ $contract_template->updated_at }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('admin.contract_templates.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('panel.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
