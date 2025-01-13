@extends('layouts.admin')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">


    {{-- flat picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">


    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    @livewireStyles
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    <a href="{{ route('admin.contracts.index') }}">{{ __('panel.manage_contracts') }}</a>

                </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    /
                    {{ __('panel.show_contracts') }}
                </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">


            <div class="pr-1 mb-3 mb-xl-0">
                {{-- <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button> --}}
                <a href="{{ route('admin.contract_templates.create') }}" class="btn btn-warning  btn-icon ml-2">
                    <i class="mdi mdi-refresh"></i>
                </a>
            </div>


        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">
                            <i class="fa fa-plus-square me-3 " style="font-size: 20px;"></i>
                            {{ __('panel.show_contracts') }}
                        </h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
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
                                <td>{{ $contract->contract_file ?? '-' }} </td>
                            </tr>

                        </table>

                        <h3>{{ __('panel.contract_text') }}</h3>
                        <div class="card">
                            <div class="card-body">
                                {!! $contract->contract_content !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ route('admin.contracts.print', $contract->id) }}"
                                class="btn btn-primary btn-sm ml-auto">
                                <i class="fa fa-print"></i>
                                {{ __('panel.contract_print') }}
                            </a>

                            <a href="{{ route('admin.contracts.pdf', $contract->id) }}"
                                class="btn btn-secondary btn-sm ml-auto">
                                <i class="fa fa-file-pdf"></i>
                                {{ __('panel.contract_export_pdf') }}
                            </a>

                            {{-- <a href="{{ route('invoice.send_to_email', $invoice->id) }}"
                                class="btn btn-success btn-sm ml-auto"><i class="fa fa-envelope"></i>
                                {{ __('Frontend/frontend.send_to_email') }}</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>


    <!-- Include the Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/{{ app()->getLocale() }}.js"></script>



    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Internal Jquery.steps js -->
    <script src="{{ URL::asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!--Internal  Form-wizard js -->
    <script src="{{ URL::asset('assets/js/form-wizard.js') }}"></script>


    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
