@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/css/mywizard.css') }}">

    <style>
        .ck.ck-editor__main>.ck-editor__editable {
            min-height: 300px !important;
        }
    </style>
@endsection


@section('content')
    {{-- main holder document  --}}
    <div class="card shadow mb-4">
        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_contract_template') }}
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
                        <a href="{{ route('admin.contract_templates.index') }}">
                            {{ __('panel.show_contract_templates') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- body part  --}}
        <div class="card-body">
            <div class="card-body">
                @livewire('document-template.create-document-template-component')
            </div>
        </div>
    @endsection


    @section('script')
        <script src="{{ asset('backend/js/form-wizard.js') }}"></script>
    @endsection
