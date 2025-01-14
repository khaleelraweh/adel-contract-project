@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Document Category Details') }}
        </div>
        <div class="card-body">
            <h5>{{ $document_category->name }}</h5>
            <p>{{ $document_category->description }}</p>
            <p>Status: {{ $document_category->status ? __('Active') : __('Inactive') }}</p>
            <p>Created at: {{ $document_category->created_at }}</p>
            <p>Updated at: {{ $document_category->updated_at }}</p>
            <a href="{{ route('admin.document_categories.index') }}" class="btn btn-primary">
                {{ __('Back to List') }}
            </a>
        </div>
    </div>
@endsection
