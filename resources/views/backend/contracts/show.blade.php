@extends('layouts.admin')

@section('css')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <style>
        /* Custom Admin Styles */
        .card {
            border: none;
            border-radius: 8px;
        }

        .card-header {
            border-radius: 8px 8px 0 0;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
    </style>
    @livewireStyles
@endsection

@section('page-header')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto">
                    <a href="{{ route('admin.contracts.index') }}" class="text-decoration-none">
                        {{ __('panel.manage_contracts') }}
                    </a>
                </h4>
                <span class="text-muted mt-1 mx-2">/</span>
                <span class="text-muted mt-1">{{ __('panel.show_contracts') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.contract_templates.create') }}" class="btn btn-warning btn-icon ml-2">
                <i class="fas fa-sync"></i>
            </a>
        </div>
    </div>
    <!-- End Breadcrumb -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-contract me-2"></i>
                        {{ __('panel.show_contracts') }}
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Contract Details Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ __('panel.contract_name') }}</th>
                                    <td>{{ $contract->contract_name }}</td>
                                    <th>{{ __('panel.contract_number') }}</th>
                                    <td>{{ $contract->contract_no ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('panel.contract_type') }}</th>
                                    <td>{{ $contract->contract_type() }}</td>
                                    <th>{{ __('panel.created_at') }}</th>
                                    <td>{{ $contract->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('panel.contract_status') }}</th>
                                    <td>{{ $contract->contract_status() }}</td>
                                    <th>{{ __('panel.contract_file') }}</th>
                                    <td>{{ $contract->contract_file ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Contract Content -->
                    <h3 class="mt-4">{{ __('panel.contract_text') }}</h3>
                    <div class="card bg-light">
                        <div class="card-body">
                            {!! $contract->contract_content !!}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <a href="{{ route('admin.contracts.print', $contract->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-print me-2"></i>
                                {{ __('panel.contract_print') }}
                            </a>
                            <a href="{{ route('admin.contracts.pdf', $contract->id) }}"
                                class="btn btn-secondary btn-sm ms-2">
                                <i class="fas fa-file-pdf me-2"></i>
                                {{ __('panel.contract_export_pdf') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/{{ app()->getLocale() }}.js"></script>
    <!-- Custom Admin JS -->
    <script src="{{ asset('js/admin.js') }}"></script>

    @livewireScripts
@endsection
