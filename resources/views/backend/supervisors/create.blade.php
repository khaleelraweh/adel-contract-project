@extends('layouts.admin')
@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_user') }}
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
                        <a href="{{ route('admin.supervisors.index') }}">
                            {{ __('panel.show_users') }}
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

                {{-- enctype used cause we will save images  --}}
                <form action="{{ route('admin.supervisors.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-sm-12 col-md-8">

                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-4">
                                    <label for="first_name"> {{ __('panel.first_name') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-4">
                                    <input type="text" id="first_name" name="first_name"
                                        value="{{ old('first_name') }}" class="form-control" placeholder="">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-4">
                                    <label for="last_name">{{ __('panel.last_name') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-4">
                                    <input type="text" id="last_name" name="last_name"
                                        value="{{ old('last_name') }}" class="form-control" placeholder="">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-4">
                                    <label for="username">{{ __('panel.user_name') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-4">
                                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                                        class="form-control" placeholder="">
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-4">
                                    <label for="password">{{ __('panel.user_password') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-4">
                                    <input type="text" id="password" name="password" value="{{ old('password') }}"
                                        class="form-control" placeholder="">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-4">
                                    <label for="email">{{ __('panel.email') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-4">
                                    <input type="text" id="email" name="email" value="{{ old('email') }}"
                                        class="form-control" placeholder="">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-4">
                                    <label for="mobile">{{ __('panel.mobile') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-4">
                                        <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                                            class="form-control" placeholder="">
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>

                            {{-- user group row --}}
                            {{-- <div class="row pt-4">
                                <div class="col-md-12 col-sm-12 ">
                                    <label for="user_groups"> {{ __('panel.user_groups') }} </label>
                                    <select name="user_groups[]" class="form-control select2 child" multiple="multiple">
                                        @forelse ($user_groups as $user_group)
                                            <option value="{{ $user_group->id }}"
                                                {{ in_array($user_group->id, old('user_groups', [])) ? 'selected' : null }}>
                                                {{ $user_group->display_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div> --}}



                        </div>

                        {{-- image of supervisor account --}}
                        <div class="col-sm-12 col-md-4">
                            <div class="row pt-3">
                                <div class="col-12">
                                    <label for="user_image"> {{ __('panel.image') }} </label>
                                    <br>
                                    <span class="form-text text-muted">{{ __('panel.user_image_size') }} </span>
                                    <div class="file-loading">
                                        <input type="file" name="user_image" id="supervisor_image"
                                            class="file-input-overview ">
                                        <span class="form-text text-muted">{{ __('panel.user_image_size') }} </span>
                                        @error('user_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="status" class="control-label">
                                        <span>{{ __('panel.status') }}</span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" id="status_active"
                                            value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_active">
                                            {{ __('panel.status_active') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status"
                                            id="status_inactive" value="0"
                                            {{ old('status') == '0' ? 'checked' : '' }}>
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


                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-2 pt-3 d-none d-md-block">
                        </div>
                        <div class="col-sm-12 col-md 10 pt-3">

                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="icon-lg  me-2" data-feather="corner-down-left"></i>
                                {{ __('panel.save_data') }}
                            </button>

                            <a href="{{ route('admin.supervisors.index') }}" name="submit"
                                class=" btn btn-outline-danger">
                                <i class="icon-lg  me-2" data-feather="x"></i>
                                {{ __('panel.cancel') }}
                            </a>

                        </div>
                    </div>

                </form>
            </div>

        </div>

    @endsection

    @section('script')
        <script>
            $(function() {
                $("#supervisor_image").fileinput({
                    theme: "fa5",
                    maxFileCount: 1,
                    allowedFileTypes: ['image'],
                    showCancel: true,
                    showRemove: false,
                    showUpload: false,
                    overwriteInitial: false
                })

            });


            //select2: code to search in data
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function(idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

            // select2 : .select2 : is  identifier used with element to be effected
            $(".select2").select2({
                tags: true,
                colseOnSelect: false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });
        </script>

        {{-- is related to select permision disable and enable by child class --}}
        <script language="javascript">
            var $cbox = $('.child').change(function() {

                if (this.checked) {
                    $cbox.not(this).attr('disabled', 'disabled');
                } else {
                    $cbox.removeAttr('disabled');
                }
            });
        </script>
    @endsection
