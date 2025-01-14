@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Document Category Details') }}
        </div>
        <div class="card-body">
            <h5>{{ $documentCategory->name }}</h5>
            <p>{{ $documentCategory->description }}</p>
            <p>Status: {{ $documentCategory->status ? __('Active') : __('Inactive') }}</p>
            <p>Created at: {{ $documentCategory->created_at }}</p>
            <p>Updated at: {{ $documentCategory->updated_at }}</p>
            <a href="{{ route('admin.document_categories.index') }}" class="btn btn-primary">
                {{ __('Back to List') }}
            </a>
        </div>
    </div>
@endsection
