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
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('panel.document_category_deails') }}</h3>
                        {{-- <a href="{{ route('admin.document_categories.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('panel.back_to_list') }}
                        </a> --}}
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Name Section -->
                        <div class="mb-4">
                            <label class="form-label text-muted small mb-1">{{ __('panel.document_category_name') }}</label>
                            <h4 class="fw-bold">{{ $document_category->getTranslation('doc_cat_name', 'ar') }}</h4>
                        </div>

                        <!-- Description Section -->
                        <div class="mb-4">
                            <label class="form-label text-muted small mb-1">{{ __('panel.document_category_note') }}</label>
                            <p class="lead">{!! $document_category->getTranslation('doc_cat_note', 'ar') !!}</p>
                        </div>

                        <!-- Status Section -->
                        <div class="mb-4">
                            <label class="form-label text-muted small mb-1">{{ __('panel.status') }}</label>
                            <p>
                                <span class="badge {{ $document_category->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $document_category->status ? __('Active') : __('Inactive') }}
                                </span>
                            </p>
                        </div>

                        <!-- Timestamps Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">{{ __('panel.published_on') }}</label>
                                <p class="fw-semibold">{{ $document_category->published_on }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">{{ __('panel.updated_at') }}</label>
                                <p class="fw-semibold">{{ $document_category->updated_at }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light d-flex justify-content-end">
                        <a href="{{ route('admin.document_categories.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('panel.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
