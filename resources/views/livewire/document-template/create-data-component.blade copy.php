<div>
    <form action="{{ route('admin.document_types.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-sm-12 col-md-2 pt-3 ">
                <label for="category_id">
                    {{ __('panel.document_category_name') }}
                </label>
            </div>

            <div class="col-sm-12 col-md-10 pt-3">

                <select class="form-control form-control-lg" wire:model="document_category_id">
                    <option value="">---</option>
                    @forelse ($document_categories as $document_category)
                        <option value="{{ $document_category->id }}">
                            {{ $document_category->doc_cat_name }}
                        </option>
                    @empty
                    @endforelse
                </select>
                @error('document_category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>


        <div class="row">
            <div class="col-sm-12 col-md-2 pt-3 ">
                <label for="document_type_id">
                    {{ __('panel.document_type_name') }}
                </label>
            </div>

            <div class="col-sm-12 col-md-10 pt-3">

                <select class="form-control form-control-lg" wire:model="document_type_id" id="document_type_id">
                    <option value="">---</option>
                    @forelse ($document_types as $document_type)
                        <option value="{{ $document_type->id }}">
                            {{ $document_type->doc_type_name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('document_type_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-2 pt-3 ">
                <label for="doc_template_name">
                    {{ __('panel.document_template_name') }}
                </label>
            </div>
            <div class="col-sm-12 col-md-10 pt-3">
                <input type="text" id="doc_template_name" wire:model="doc_template_name" name="doc_template_name"
                    id="doc_template_name" value="{{ old('doc_template_name') }}" class="form-control" placeholder="">
                @error('doc_template_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-2 pt-3 ">
                <label for="language">
                    {{ __('panel.language') }}
                </label>
            </div>
            <div class="col-sm-12 col-md-3 pt-3">
                <select name="language" wire:model.defer="language" class="form-control" id="language">
                    <option value="">---</option>
                    <option value="1" {{ old('language') == '1' ? 'selected' : null }}>
                        {{ __('panel.language_ar') }}
                    </option>
                    <option value="2" {{ old('language') == '2' ? 'selected' : null }}>
                        {{ __('panel.language_en') }}
                    </option>
                    <option value="3" {{ old('language') == '3' ? 'selected' : null }}>
                        {{ __('panel.language_both') }}
                    </option>

                </select>
                @error('language')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-md-2 pt-3">
                {{ __('panel.published_on') }}
            </div>
            <div class="col-sm-12 col-md-10 pt-3">
                <div class="input-group flatpickr" id="flatpickr-datetime">
                    <input type="text" name="published_on" value="{{ old('published_on') }}" class="form-control"
                        placeholder="Select date" data-input>
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
                    <input type="radio" class="form-check-input" name="status" id="status_active" value="1"
                        {{ old('status', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="status_active">
                        {{ __('panel.status_active') }}
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="status" id="status_inactive" value="0"
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


    </form>
</div>
