@extends('layouts.admin')

@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_document_type') }}
                </h3>
                <ul class="breadcrumb pt-2">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            /
                        @else
                            \
                        @endif
                    </li>
                    <li class="ms-1">
                        <a href="{{ route('admin.document_types.index') }}">
                            {{ __('panel.show_document_types') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        {{-- body part  --}}
        <div class="card-body">

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger pt-0 pb-0 mb-0">
                        <ul class="px-2 py-3 m-0" style="list-style-type: circle">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.document_types.update', $document_type->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                                type="button" role="tab" aria-controls="content"
                                aria-selected="true">{{ __('panel.content_tab') }}</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="category_id"> {{ __('panel.document_category_name') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <select name="document_category_id" class="form-control">
                                        <option value=""> {{ __('panel.category_name') }} __ </option>
                                        @forelse ($document_categories as $document_category)
                                            <option value="{{ $document_category->id }}"
                                                {{ old('document_category_id', $document_type->document_category_id) == $document_category->id ? 'selected' : null }}>
                                                {{ $document_category->doc_cat_name }} </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            @foreach (config('locales.languages') as $key => $val)
                                <div class="row ">
                                    <div class="col-sm-12 col-md-2 pt-3">
                                        <label for="title[{{ $key }}]">
                                            {{ __('panel.document_type_name') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-10 pt-3">
                                        <input type="text" name="doc_type_name[{{ $key }}]"
                                            id="doc_type_name[{{ $key }}]"
                                            value="{{ old('doc_type_name.' . $key, $document_type->getTranslation('doc_type_name', $key)) }}"
                                            class="form-control">
                                        @error('doc_type_name.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                            @endforeach

                            @foreach (config('locales.languages') as $key => $val)
                                <div class="row ">
                                    <div class="col-sm-12 col-md-2 pt-3">
                                        <label for="doc_type_note[{{ $key }}]">
                                            {{ __('panel.document_type_note') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-10 pt-3">
                                        <textarea id="tinymceExample" name="doc_type_note[{{ $key }}]" rows="10" class="form-control ">{!! old('doc_type_note.' . $key, $document_type->getTranslation('doc_type_note', $key)) !!}</textarea>
                                        @error('doc_type_note.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    {{ __('panel.published_on') }}
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <div class="input-group flatpickr" id="flatpickr-datetime">
                                        <input type="text" name="published_on" class="form-control"
                                            placeholder="Select date" data-input
                                            value="{{ old('published_on', $document_type->published_on ? \Carbon\Carbon::parse($document_type->published_on)->format('Y/m/d h:i A') : '') }}">
                                        <span class="input-group-text input-group-addon" data-toggle>
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="status" class="control-label">
                                        <span>{{ __('panel.status') }}</span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" id="status_active"
                                            value="1"
                                            {{ old('status', $document_type->status) == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_active">
                                            {{ __('panel.status_active') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" id="status_inactive"
                                            value="0"
                                            {{ old('status', $document_type->status) == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_inactive">
                                            {{ __('panel.status_inactive') }}
                                        </label>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3 d-none d-md-block">
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="icon-lg  me-2" data-feather="corner-down-left"></i>
                                    {{ __('panel.update_data') }}
                                </button>

                                <a href="{{ route('admin.document_types.index') }}" name="submit"
                                    class=" btn btn-outline-danger">
                                    <i class="icon-lg  me-2" data-feather="x"></i>
                                    {{ __('panel.cancel') }}
                                </a>

                            </div>
                        </div>

                    </div>



                </form>
            </div>

        </div>
    @endsection


    @section('script')
        <script>
            $(function() {
                $('.summernote').summernote({
                    tabSize: 2,
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });

                $('#published_on').pickadate({
                    format: 'yyyy-mm-dd',
                    min: new Date(),
                    selectMonths: true, // Creates a dropdown to control month
                    selectYears: true, // creates a dropdown to control years
                    clear: 'Clear',
                    close: 'OK',
                    colseOnSelect: true // Close Upon Selecting a date
                });
                var publishedOn = $('#published_on').pickadate(
                    'picker'); // set startdate in the picker to the start date in the #start_date elemet

                // when change date 
                $('#published_on').change(function() {
                    selected_ci_date = "";
                    selected_ci_date = now() // make selected start date in picker = start_date value  

                });

                $('#published_on_time').pickatime({
                    clear: ''
                });

            });
        </script>
    @endsection
