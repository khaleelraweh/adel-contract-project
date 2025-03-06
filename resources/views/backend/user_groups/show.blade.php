@extends('layouts.admin')

@section('content')
    {{-- Main holder page --}}
    <div class="card shadow mb-4">

        {{-- Breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-eye"></i>
                    {{ __('panel.show_role_detials') }}
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
                        <a href="{{ route('admin.user_groups.index') }}">
                            {{ __('panel.show_roles') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Body part --}}
        <div class="card-body">

            {{-- Supervisor Details --}}
            <div class="row">


            </div>

            {{-- Back Button --}}
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <a href="{{ route('admin.user_groups.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-2"></i>
                        {{ __('panel.back_to_list') }}
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        // Additional scripts can be added here if needed
    </script>
@endsection
