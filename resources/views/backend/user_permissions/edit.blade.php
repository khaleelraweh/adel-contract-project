@extends('layouts.admin')


@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_role_user') }}
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
                <form action="{{ route('admin.user_permissions.update', $user->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')



                    {{-- user  row --}}
                    <div class="row pt-4">

                        <div class="col-md-12 col-sm-12 ">

                            <label for="user_id"> {{ __('panel.users') }} </label>
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
                    <div class="row pt-4">

                        <div class="col-md-12 col-sm-12 ">

                            <label for="roles"> {{ __('panel.roles') }} </label>
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


                    <div class="row pt-4">
                        <div class="col-sm-12">
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
                    </div>

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

            // select2 : .select2 : is  identifier used with element to be effected
            $(".select2").select2({
                tags: true,
                colseOnSelect: false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });
        </script>

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
