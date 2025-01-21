<div>

    <style>
        .list-group-item {
            padding: 0.75rem 1.25rem;
            margin-bottom: -1px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>

    <style>
        .activePage {
            background-color: #0162e8;
            color: white;
            cursor: pointer;
        }

        .activePage:hover {
            color: #ffee99;
            cursor: pointer;
        }

        .unActivePage {
            background-color: #DDE2EF;
            color: black;
        }

        .activeGroup {
            background-color: #01616D !important;
        }
    </style>

    <style>
        .tree {
            list-style: none;
            padding-left: 0;
        }

        .tree-item {
            margin-bottom: 5px;
        }

        .tree-item-header {
            border-radius: 6px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .tree-item-header:hover {
            background-color: #e9ecef !important;
            color: #000 !important;
        }

        .tree-item-content {
            padding-right: 20px;
            border-right: 2px solid #ddd;
            margin-right: 10px;
        }

        .list-group-item {
            padding: 0.5rem 1rem;
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-bottom: 5px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #0162e8;
            border-color: #0162e8;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0152c8;
            border-color: #0152c8;
        }

        .text-danger {
            transition: color 0.3s ease;
        }

        .text-danger:hover {
            color: #c82333 !important;
        }
    </style>

    <div class="mywizard">
        <div class="steps clearfix">
            <ul role="tablist">
                <li role="tab" wire:click="directMoveToStep(1)" class="first {{ $currentStep == 1 ? 'current' : '' }}"
                    aria-disabled="false" aria-selected="true">
                    <a id="wizard1-t-0" href="#wizard1-h-0" aria-controls="wizard1-p-0">
                        <span class="current-info audible">current step:
                        </span>
                        <span class="number">1</span>
                        <span class="title">
                            {{ __('panel.document_template_data') }}
                        </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(2)"
                    class="disabled {{ $currentStep == 2 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-1" href="#wizard1-h-1" aria-controls="wizard1-p-1">
                        <span class="number">2</span>
                        <span class="title"> {{ __('panel.document_template_text') }} </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(3)"
                    class="disabled {{ $currentStep == 3 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-1" href="#wizard1-h-1" aria-controls="wizard1-p-1">
                        <span class="number">3</span>
                        <span class="title"> {{ __('panel.document_template_variables') }} </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(4)"
                    class="disabled last {{ $currentStep == 4 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-2" href="#wizard1-h-2" aria-controls="wizard1-p-2"><span class="number">4</span>
                        <span class="title">
                            {{ __('panel.document_and_template_formatting') }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="mycontent">

            {{-- step 1 : بيانات نموذج الوثيقة --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 1 ? 'current' : '' }} ">
                {{ __('panel.document_template_data') }}
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 1 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 1 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 1 ? 'block' : 'none' }}">


                <form action="{{ route('admin.document_templates.store') }}" method="post">
                    @csrf

                    <!-- document category -->
                    <div class="row">

                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="document_category_id" class="text-small text-uppercase">
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
                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="document_type_id" class="text-small text-uppercase">
                                {{ __('panel.document_type_name') }}
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-10 pt-3">
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

                    <div class="row">
                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="doc_template_name"> {{ __('panel.document_template_name') }}
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-10 pt-3">
                            <input type="text" id="doc_template_name" wire:model="doc_template_name"
                                name="doc_template_name" value="{{ old('doc_template_name') }}" class="form-control"
                                placeholder="">
                            @error('doc_template_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="language"> {{ __('panel.language') }} </label>
                        </div>
                        <div class="col-sm-12 col-md-10 pt-3">
                            <select name="language" wire:model.defer="language" class="form-control">
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

                    <div class="row" wire:ignore>
                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="published_on">
                                {{ __('panel.published_on') }}
                            </label>
                        </div>

                        <div class="col-sm-12 col-md-10 pt-3">
                            <div class="input-group flatpickr" id="flatpickr-datetime">
                                <input type="text" name="published_on" wire:model.defer="published_on"
                                    value="{{ old('published_on') }}" class="form-control" placeholder="Select date"
                                    data-input readonly>
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
                                <input type="radio" class="form-check-input" name="status"
                                    wire:model.defer="status" id="status_active" value="1"
                                    {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_active">
                                    {{ __('panel.status_active') }}
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="status"
                                    wire:model.defer="status" id="status_inactive" value="0"
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
            </section>

            {{-- step 2 : نص نموذج الوثيقة  --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 2 ? 'current' : '' }} ">
                {{ __('panel.document_template_text') }}
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 2 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 2 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 2 ? 'block' : 'none' }}">


                <div wire:ignore>

                    <textarea name="doc_template_text" id="tinymceExample" rows="10" class="form-control"
                        wire:model.defer="doc_template_text" placeholder=""></textarea>
                    @error('tinymceExample')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @error('doc_template_text')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let editorInstance2;

                        // Initialize TinyMCE
                        tinymce.init({
                            selector: '#tinymceExample', // Select the textarea by its ID
                            language: typeof tinymceLanguage !== 'undefined' ? tinymceLanguage :
                            'ar', // Default to 'ar' if no language set
                            min_height: 350,
                            default_text_color: 'red',
                            plugins: [
                                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                                "save table contextmenu directionality emoticons template paste textcolor image"
                            ],
                            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                            templates: [{
                                    title: 'Test template 1',
                                    content: 'Test 1'
                                },
                                {
                                    title: 'Test template 2',
                                    content: 'Test 2'
                                }
                            ],
                            content_css: [],
                            image_title: true,
                            automatic_uploads: true,
                            file_picker_types: 'image',
                            file_picker_callback: function(cb, value, meta) {
                                var input = document.createElement('input');
                                input.setAttribute('type', 'file');
                                input.setAttribute('accept', 'image/*');
                                input.onchange = function() {
                                    var file = this.files[0];
                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var id = 'blobid' + (new Date()).getTime();
                                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                        var base64 = reader.result.split(',')[1];
                                        var blobInfo = blobCache.create(id, file, base64);
                                        blobCache.add(blobInfo);
                                        cb(blobInfo.blobUri(), {
                                            title: file.name
                                        });
                                    };
                                    reader.readAsDataURL(file);
                                };
                                input.click();
                            },
                            image_advtab: true,
                            contextmenu: 'image align | link',
                            content_style: `
                                body { font-family:Helvetica,Arial,sans-serif; font-size:14px }
                                img { display: block; margin-left: auto; margin-right: auto; }
                            `,
                            setup: function(editor) {
                                editorInstance2 = editor;

                                // Set the initial text from Livewire when event is triggered
                                @this.on('updateDocTemplateText', (text) => {
                                    editor.setContent(text);
                                });

                                // Sync TinyMCE data with Livewire when content changes
                                editor.on('change keyup', () => {
                                    @this.set('doc_template_text', editor.getContent());
                                });

                                // Add alignment toolbar for images
                                editor.ui.registry.addContextToolbar('imagealign', {
                                    predicate: function(node) {
                                        return node.nodeName.toLowerCase() === 'img';
                                    },
                                    items: 'alignleft aligncenter alignright',
                                    position: 'node',
                                    scope: 'node'
                                });
                            }
                        });

                        // Update TinyMCE content when Livewire triggers an event
                        Livewire.on('updateDocTemplateText', text => {
                            if (editorInstance2) {
                                editorInstance2.setContent(text);
                            }
                        });
                    });
                </script>




            </section>

            {{-- step 3 : متغيرات نموذج الوثيقة  --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 3 ? 'current' : '' }} ">

                <div class="row align-items-end mb-4 mb-md-0">
                    <div class="col-md mb-4 mb-md-0">
                        <h4>{{ __('panel.document_template_variables') }}</h4>
                    </div>
                    <div class="col-md-auto aos-init aos-animate" data-aos="fade-start">
                        <button wire:click="saveStepThreeDataUsingBtn" class="btn btn-primary">
                            {{ __('panel.document_template_variables_save') }}
                        </button>
                    </div>
                </div>
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 3 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 3 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 3 ? 'block' : 'none' }}">

                <div class="row">
                    {{-- start template --}}
                    <div class="col-sm-12 col-md-4 pt-3">
                        <div class="d-flex justify-content-between mb-3 pb-2" style="border-bottom: 4px solid gray">
                            <h4>{{ __('panel.the_pages') }}</h4>
                            <a wire:click.prevent="addPage()" class="d-block pt-2" style="cursor: pointer;">
                                <i class="fas fa-plus-square text-primary me-3"></i> {{ __('panel.add_page') }}
                            </a>
                        </div>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @foreach ($pages as $index => $page)
                                <li class="input-group p-2 mb-1"
                                    style="background: {{ $currentPageIndex == $index ? '#0162e8' : '#DDE2EF' }} ; border-radius:0.25em">

                                    <span
                                        class="px-2 d-flex align-items-center cursor-pointer {{ $currentPageIndex == $index ? 'activePage' : 'unActivePage' }}"
                                        style="flex:1;border:none;cursor: pointer;"
                                        wire:click="setActivePage({{ $index }})">
                                        {{ $page['doc_page_name'] }}
                                    </span>

                                    <div class="d-flex align-items-center">
                                        <a class="px-2 {{ $currentPageIndex == $index ? 'activePage' : '' }}"
                                            wire:click.prevent="removePage({{ $index }})"
                                            style="border: none;cursor: pointer;"
                                            title="{{ __('panel.remove_page') }}">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        <a class="px-2 {{ $currentPageIndex == $index ? 'activePage' : '' }}"
                                            wire:click="setActivePage({{ $index }})"
                                            style="border: none;cursor: pointer;"
                                            title="{{ __('panel.set_active') }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="px-2 {{ $currentPageIndex == $index ? 'activePage' : '' }}"
                                            wire:click.prevent="addGroup({{ $index }})"
                                            style="border: none;cursor: pointer;"
                                            title="{{ __('panel.add_group') }}">
                                            <i class="fas fa-plus-square "></i>
                                            {{-- {{ __('panel.add_group') }} --}}
                                        </a>
                                    </div>
                                </li>
                                <div class="tree-item-content pl-3 mt-2">
                                    @if (isset($pages[$currentPageIndex]) && $currentPageIndex == $index)
                                        <div class="row">
                                            <div class="col-sm-12">

                                                @foreach ($pages[$currentPageIndex]['groups'] as $groupIndex => $group)
                                                    <div class="tree-item mb-2">
                                                        <div class="card mb-2">
                                                            <div class="card-body p-0">
                                                                <div class="input-group p-2"
                                                                    style="background: {{ $groupIndex == $activeGroupIndex ? '#01616D' : '#DDE2EF' }};">
                                                                    <span
                                                                        class="px-2 d-flex align-items-center {{ $groupIndex == $activeGroupIndex ? 'activeGroup' : '' }} "
                                                                        style="flex:1;border: none;cursor: pointer;"
                                                                        wire:click="setActiveGroup({{ $currentPageIndex }}, {{ $groupIndex }})">
                                                                        {{ $group['pg_name'] }}

                                                                    </span>
                                                                    {{-- <input type="text" class="form-control"
                                                                    wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.pg_name"
                                                                    aria-label="{{ __('panel.Enter a Group Name') }}"> --}}

                                                                    <div class="d-flex align-items-center">
                                                                        <a class="px-2 {{ $groupIndex == $activeGroupIndex ? 'activeGroup' : '' }}"
                                                                            style="border: none; cursor: pointer;"
                                                                            wire:click.prevent="removeGroup({{ $currentPageIndex }}, {{ $groupIndex }})">
                                                                            <i
                                                                                class="fas fa-trash-alt {{ $groupIndex == $activeGroupIndex ? 'text-white' : 'text-danger' }}"></i>
                                                                        </a>
                                                                        <a class="px-2 {{ $groupIndex == $activeGroupIndex ? 'activeGroup' : '' }}"
                                                                            style="border: none; cursor: pointer;"
                                                                            wire:click="setActiveGroup({{ $currentPageIndex }}, {{ $groupIndex }})">
                                                                            <i class="far fa-edit"></i>
                                                                        </a>
                                                                        <a class="px-2 {{ $groupIndex == $activeGroupIndex ? 'activeGroup' : '' }}"
                                                                            wire:click.prevent="addVariable({{ $currentPageIndex }}, {{ $groupIndex }})"
                                                                            style="border: none; cursor: pointer;">
                                                                            <i class="fas fa-plus-circle "></i>
                                                                            {{-- {{ __('panel.add_variable') }} --}}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                @error('pages.' . $currentPageIndex . '.groups.' .
                                                                    $groupIndex . '.pg_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="card-footer p-0">
                                                                <div class="tree-item-content pl-3 mt-2">
                                                                    <ul class="list-group list-group-flush">
                                                                        @foreach ($group['variables'] as $variableIndex => $variable)
                                                                            <li class="list-group-item"
                                                                                wire:click="setActiveVariable({{ $currentPageIndex }}, {{ $groupIndex }}, {{ $variableIndex }})"
                                                                                style="cursor: pointer;">
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <span class="d-inline-block">
                                                                                        {{ $variable['pv_name'] }}
                                                                                    </span>
                                                                                    <a
                                                                                        wire:click.prevent="removeVariable({{ $index }}, {{ $groupIndex }}, {{ $variableIndex }})">
                                                                                        <i
                                                                                            class="fas fa-trash-alt text-danger"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </li>
                                                                        @endforeach
                                                                        <!-- Add Variable Button -->
                                                                        {{-- <li class="list-group-item">
                                                                <a href=""
                                                                    wire:click.prevent="addVariable({{ $currentPageIndex }}, {{ $groupIndex }})"
                                                                    style="cursor: pointer;">
                                                                    <i class="fas fa-plus-circle me-2"></i>
                                                                    {{ __('panel.add_variable') }}
                                                                </a>
                                                            </li> --}}
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <!-- this will be for add group  -->
                                                {{-- <div class="d-flex justify-content-between">
                                                <a wire:click.prevent="addGroup({{ $currentPageIndex }})"
                                                    class="d-block pt-2" style="cursor: pointer;">
                                                    <i class="fas fa-plus-square text-primary me-3"></i>
                                                    {{ __('panel.add_group') }}
                                                </a>
                                            </div> --}}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </ul>
                        {{-- <div class="d-flex justify-content-between">
                            <a wire:click.prevent="addPage()" class="d-block pt-2" style="cursor: pointer;">
                                <i class="fas fa-plus-square text-primary me-3"></i> {{ __('panel.add_page') }}
                            </a>
                        </div> --}}
                    </div>

                    <div class="col-sm-12 col-md-8 pt-3">
                        @if (isset($pages[$currentPageIndex]))
                            <div class="card">
                                <div class="card-header mb-0 pb-0">
                                    <h2><i class="far fa-edit" style="color: #0162e8"></i> {{ __('panel.page') }}
                                        {{ $currentPageIndex + 1 }}</h2>
                                </div>
                                <div class="card-body mt-0 pt-0">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 pt-3">
                                            <label
                                                for="{{ $pages[$currentPageIndex]['doc_page_name'] }}">{{ __('panel.page_title') }}</label>
                                            <input type="text" class="form-control"
                                                id="pages.{{ $currentPageIndex }}.doc_page_name"
                                                wire:model.defer="pages.{{ $currentPageIndex }}.doc_page_name">
                                            @error('pages.' . $currentPageIndex . '.doc_page_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-8 pt-3">
                                            <label for="{{ $pages[$currentPageIndex]['doc_page_description'] }}">
                                                {{ __('panel.page_description') }}
                                            </label>
                                            <input type="text" class="form-control"
                                                id="{{ $pages[$currentPageIndex]['doc_page_description'] }}"
                                                wire:model.defer="pages.{{ $currentPageIndex }}.doc_page_description">
                                            @error('pages.' . $currentPageIndex . '.doc_page_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Add Input Field for Group Name -->
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 pt-3">
                                            <label for="pg_name">{{ __('panel.group_name') }}</label>
                                            <input type="text" class="form-control"
                                                wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $activeGroupIndex }}.pg_name"
                                                placeholder="{{ __('panel.enter_group_name') }}">
                                            @error('pages.' . $currentPageIndex . '.groups.' . $activeGroupIndex .
                                                '.pg_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 pt-4">
                                            @if (isset($pages[$currentPageIndex]['groups'][$activeGroupIndex]['variables'][$activeVariableIndex]))
                                                @php
                                                    $variable =
                                                        $pages[$currentPageIndex]['groups'][$activeGroupIndex][
                                                            'variables'
                                                        ][$activeVariableIndex];
                                                @endphp
                                                <div class="card">
                                                    <div class="card-header mb-0">
                                                        <h3 class="mb-0">{{ __('panel.variable') }}
                                                            {{ $activeVariableIndex + 1 }}</h3>
                                                    </div>
                                                    <div class="card-body mt-0">
                                                        <!-- Variable details form -->
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="pv_name">{{ __('panel.pv_name') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $activeGroupIndex }}.variables.{{ $activeVariableIndex }}.pv_name">
                                                                    @error('pages.' . $currentPageIndex . '.groups.' .
                                                                        $activeGroupIndex . '.variables.' .
                                                                        $activeVariableIndex . '.pv_name')
                                                                        <span
                                                                            class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="pv_question">{{ __('panel.pv_question') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $activeGroupIndex }}.variables.{{ $activeVariableIndex }}.pv_question">
                                                                    @error('pages.' . $currentPageIndex . '.groups.' .
                                                                        $activeGroupIndex . '.variables.' .
                                                                        $activeVariableIndex . '.pv_question')
                                                                        <span
                                                                            class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6 pt-3">
                                                                <label
                                                                    for="pv_type">{{ __('panel.pv_type') }}</label>
                                                                <select name="pv_type" class="form-control"
                                                                    wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $activeGroupIndex }}.variables.{{ $activeVariableIndex }}.pv_type">
                                                                    <option value="0">
                                                                        {{ __('panel.pv_type_text') }}</option>
                                                                    <option value="1">
                                                                        {{ __('panel.pv_type_number') }}</option>
                                                                    <option value="2">
                                                                        {{ __('panel.pv_type_date') }}</option>
                                                                </select>
                                                                @error('pages.' . $currentPageIndex . '.groups.' .
                                                                    $activeGroupIndex . '.variables.' . $activeVariableIndex
                                                                    . '.pv_type')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 pt-3">
                                                                <label
                                                                    for="pv_required">{{ __('panel.pv_required') }}</label>
                                                                <select name="pv_required" class="form-control"
                                                                    wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $activeGroupIndex }}.variables.{{ $activeVariableIndex }}.pv_required">
                                                                    <option value="1">{{ __('panel.yes') }}
                                                                    </option>
                                                                    <option value="0">{{ __('panel.no') }}
                                                                    </option>
                                                                </select>
                                                                @error('pages.' . $currentPageIndex . '.groups.' .
                                                                    $activeGroupIndex . '.variables.' . $activeVariableIndex
                                                                    . '.pv_required')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        {{--  pv_details field --}}
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12 pt-3">
                                                                <label for="pv_details">
                                                                    {{ __('panel.pv_details') }}
                                                                </label>
                                                                <textarea name="pv_details" rows="10" class="form-control summernote"
                                                                    wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $activeGroupIndex }}.variables.{{ $activeVariableIndex }}.pv_details">
                                                                    {!! old('pv_details') !!}
                                                                </textarea>
                                                                @error('pages.' . $currentPageIndex . '.groups.' .
                                                                    $groupIndex . '.variables.' . $variableIndex .
                                                                    '.pv_details')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <!-- Additional fields for variable details -->
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- step 4 : تنسيق الوثيقة والمستند --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 4 ? 'current' : '' }} ">
                {{ __('panel.document_and_template_formatting') }}
            </h3>
            <section id="wizard1-p-3" role="tabpanel" aria-labelledby="wizard1-h-3"
                class="body {{ $currentStep == 4 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 4 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 4 ? 'block' : 'none' }}">

                <div class="row">
                    <div class="col-sm-12 col-md-4 pt-3">
                        <label for="pv_name">{{ __('panel.select_pv_name') }}</label>
                        <select name="pv_name" class="form-control">
                            <option value="" selected>-- {{ __('panel.select_variable') }} --</option>
                            @if ($documentTemplate)
                                @if ($documentTemplate->documentPages->isNotEmpty())
                                    @foreach ($documentTemplate->documentPages as $page)
                                        @foreach ($page->pageGroups as $group)
                                            @foreach ($group->pageVariables as $variable)
                                                <option value="{{ $variable->id }}">{{ $variable->pv_name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @else
                                    <option value="">No pages available</option>
                                @endif
                            @else
                                <p>No document template found.</p>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-8 pt-3" wire:ignore>
                        <textarea name="doc_template_text" id="tinymceEditor" class="form-control">{{ $doc_template_text }}</textarea>
                    </div>
                </div>
            </section>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize TinyMCE editor
                    tinymce.init({
                        selector: '#tinymceEditor',
                        language: 'ar', // Set the editor language
                        min_height: 350,
                        default_text_color: 'red',
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor image",
                        ],
                        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        templates: [{
                                title: 'Test template 1',
                                content: 'Test 1'
                            },
                            {
                                title: 'Test template 2',
                                content: 'Test 2'
                            }
                        ],
                        content_css: [],

                        // Enable image title and upload functionality
                        image_title: true,
                        automatic_uploads: true,
                        file_picker_types: 'image',
                        file_picker_callback: function(cb, value, meta) {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');

                            input.onchange = function() {
                                var file = this.files[0];
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var id = 'blobid' + (new Date()).getTime();
                                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                    var base64 = reader.result.split(',')[1];
                                    var blobInfo = blobCache.create(id, file, base64);
                                    blobCache.add(blobInfo);

                                    cb(blobInfo.blobUri(), {
                                        title: file.name
                                    });
                                };
                                reader.readAsDataURL(file);
                            };

                            input.click();
                        },

                        // Add alignment options for images in the toolbar
                        image_advtab: true,

                        contextmenu: 'image align | link',

                        content_style: `
                            body { font-family:Helvetica,Arial,sans-serif; font-size:14px }
                            img { display: block; margin-left: auto; margin-right: auto; }
                        `,

                        setup: function(editor) {
                            // Handle Livewire integration
                            editor.on('init', function() {
                                @this.on('updateDocTemplateText', (text) => {
                                    editor.setContent(text);
                                });
                            });

                            // Handle select changes for inserting variables
                            document.querySelector('select[name="pv_name"]').addEventListener('change',
                                function() {
                                    const selectedValue = this.value;
                                    const selectedText = this.options[this.selectedIndex].text;

                                    if (selectedValue) {
                                        const placeholder = `{!-${selectedValue}-${selectedText}!}`;
                                        editor.execCommand('mceInsertContent', false, placeholder);
                                    }
                                });

                            // Sync TinyMCE data with Livewire
                            editor.on('change', function() {
                                @this.set('doc_template_text', editor.getContent());
                            });

                            // Add custom image alignment toolbar
                            editor.ui.registry.addContextToolbar('imagealign', {
                                predicate: function(node) {
                                    return node.nodeName.toLowerCase() === 'img';
                                },
                                items: 'alignleft aligncenter alignright',
                                position: 'node',
                                scope: 'node'
                            });
                        }
                    });

                    // Update editor content when triggered by Livewire
                    Livewire.on('updateDocTemplateText', text => {
                        const editor = tinymce.get('tinymceEditor');
                        if (editor) {
                            editor.setContent(text);
                        }
                    });
                });
            </script>







        </div>

        <div class="actions clearfix">
            <ul role="menu" aria-label="Pagination">
                <li class="{{ $currentStep == 1 ? 'disabled' : '' }}"
                    aria-disabled="{{ $currentStep == 1 ? 'true' : 'false' }} ">
                    <a href="#previous" style="display: {{ $currentStep == 1 ? 'none' : 'none' }} ;"
                        role="menuitem">
                        Previous
                    </a>
                    <a href="#previous" wire:click="previousStep"
                        style="display: {{ $currentStep == 1 ? 'none' : 'block' }} ;" role="menuitem">
                        {{ __('panel.previous') }}
                    </a>
                </li>
                <li aria-hidden="false" aria-disabled="false"
                    style="display: {{ $currentStep == 4 ? 'none' : 'block' }}">
                    <a href="#next" wire:click="nextStep" role="menuitem">
                        <!-- next -->
                        @if ($currentStep == 1)
                            {{ __('panel.document_template_text') }} >>
                        @else
                            @if ($currentStep == 2)
                                {{ __('panel.document_template_variables') }} >>
                            @else
                                {{ __('panel.document_and_template_formatting') }} >>
                            @endif
                        @endif
                    </a>

                </li>
                <li aria-hidden="true" style="display: {{ $currentStep == 4 ? 'block' : 'none' }}"><a
                        href="#finish" wire:click="finish" role="menuitem">{{ __('panel.finish') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
