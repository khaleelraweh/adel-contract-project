@extends('layouts.admin')
@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">


        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_user_permission') }}
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
                        <a href="{{ route('admin.user_permissions.index') }}">
                            {{ __('panel.show_user_permissions') }}
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
                <form action="{{ route('admin.user_permissions.store') }}" method="post" enctype="multipart/form-data">
                    @csrf


                    {{-- user  row --}}
                    <div class="row">
                        <div class="col-sm-12 col-md-3 pt-3">
                            <label for="user_id"> {{ __('panel.user') }} </label>
                        </div>
                        <div class="col-sm-12 col-md-9 pt-3">
                            <select name="user_id" class="form-control select2 child" id="user_id">
                                @forelse ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, old('users', [])) ? 'selected' : null }}>
                                        {{ $user->first_name . " " .$user->last_name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    {{-- roles  row --}}
                    <div class="row">
                        <div class="col-sm-12 col-md-3 pt-3">
                            <label for="user_id"> {{ __('panel.user_roles') }} </label>
                        </div>
                        <div class="col-sm-12 col-md-9 pt-3">
                            <select name="roles[]" class="form-control select2 child " multiple="multiple">
                                @forelse ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ in_array($role->id, old('roles', [])) ? 'selected' : null }}>
                                        {{ $role->display_name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-sm-12 col-md-3 pt-3">
                            <label for="user_id"> {{ __('panel.manage_permissions') }} </label>
                        </div>
                        <div class="col-sm-12 col-md-9 pt-3">
                            @foreach ($permissions as $parentPermission)
                                <div class="permission-group">
                                    <!-- Parent Permission Checkbox -->
                                    <div class="permission-title">
                                        <input type="checkbox" name="permissions[]" value="{{ $parentPermission->id }}"
                                            id="permission_{{ $parentPermission->id }}" class="parent-checkbox"
                                            {{ in_array($parentPermission->id, old('permissions', [])) ? 'checked' : '' }} />
                                        <label class="fw-bold"
                                            for="permission_{{ $parentPermission->id }}">{{ $parentPermission->display_name }}</label>
                                    </div>
                                    <!-- Child Permissions -->
                                    @if ($parentPermission->children->count() > 0)
                                        <ul class="child-permissions" style="list-style-type:none;">
                                            @foreach ($parentPermission->children as $childPermission)
                                                <li>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $childPermission->id }}"
                                                        id="permission_{{ $childPermission->id }}"
                                                        class="child-checkbox parent-{{ $parentPermission->id }}"
                                                        data-parent="permission_{{ $parentPermission->id }}"
                                                        {{ in_array($childPermission->id, old('permissions', [])) ? 'checked' : '' }} />
                                                    <label
                                                        for="permission_{{ $childPermission->id }}">{{ $childPermission->display_name }}</label>

                                                    <!-- Sub-Child Permissions -->
                                                    @if ($childPermission->children->count() > 0)
                                                        <ul class="sub-child-permissions" style="list-style-type: none;">
                                                            @foreach ($childPermission->children as $subChildPermission)
                                                                <li>
                                                                    <input type="checkbox" name="permissions[]"
                                                                        value="{{ $subChildPermission->id }}"
                                                                        id="permission_{{ $subChildPermission->id }}"
                                                                        class="sub-child-checkbox child-{{ $childPermission->id }}"
                                                                        data-parent="permission_{{ $childPermission->id }}"
                                                                        {{ in_array($subChildPermission->id, old('permissions', [])) ? 'checked' : '' }} />
                                                                    <label
                                                                        for="permission_{{ $subChildPermission->id }}">{{ $subChildPermission->display_name }}</label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-sm-12 col-md-2 pt-3 d-none d-md-block">
                        </div>
                        <div class="col-sm-12 col-md 10 pt-3">

                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="icon-lg  me-2" data-feather="corner-down-left"></i>
                                {{ __('panel.save_data') }}
                            </button>

                            <a href="{{ route('admin.user_permissions.index') }}" name="submit"
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

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Parent checkbox toggles all children
                document.querySelectorAll('.parent-checkbox').forEach(parentCheckbox => {
                    parentCheckbox.addEventListener('change', function() {
                        let parentId = this.id;
                        let childCheckboxes = document.querySelectorAll(
                            `.child-checkbox.parent-${parentId}`);
                        childCheckboxes.forEach(child => {
                            child.checked = this.checked;
                            // Trigger change event to update sub-children
                            child.dispatchEvent(new Event('change'));
                        });
                    });
                });

                // Child checkbox toggles its sub-children
                document.querySelectorAll('.child-checkbox').forEach(childCheckbox => {
                    childCheckbox.addEventListener('change', function() {
                        let childId = this.id;
                        let subChildCheckboxes = document.querySelectorAll(
                            `.sub-child-checkbox.child-${childId}`);
                        subChildCheckboxes.forEach(subChild => {
                            subChild.checked = this.checked;
                        });

                        // If a child is checked, ensure its parent is checked
                        let parentCheckbox = document.getElementById(this.dataset.parent);
                        if (this.checked) {
                            parentCheckbox.checked = true;
                        }
                    });
                });

                // Sub-child checkbox should check its parent
                document.querySelectorAll('.sub-child-checkbox').forEach(subChildCheckbox => {
                    subChildCheckbox.addEventListener('change', function() {
                        let parentCheckbox = document.getElementById(this.dataset.parent);
                        if (this.checked) {
                            parentCheckbox.checked = true;
                        }
                    });
                });
            });
        </script>
    @endsection
