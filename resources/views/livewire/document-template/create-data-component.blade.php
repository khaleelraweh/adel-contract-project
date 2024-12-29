<div>
    <form action="{{ route('admin.document_types.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- document category -->
        <div class="row">

            <div class="col-sm-12 col-md-6   pt-3">
                <label for="document_category_id" class="text-small text-uppercase">
                    {{ __('panel.document_category_name') }} </label>
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

            <div class="col-sm-12  col-md-6 pt-3">

                <label for="document_type_id" class="text-small text-uppercase">
                    {{ __('panel.document_type_name') }}
                </label>
                <select class="form-control form-control-lg" wire:model="document_type_id">
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



    </form>
</div>
