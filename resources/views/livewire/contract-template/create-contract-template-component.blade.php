<div>

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
                            {{ __('panel.contract_template_data') }}
                        </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(2)"
                    class="disabled {{ $currentStep == 2 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-1" href="#wizard1-h-1" aria-controls="wizard1-p-1">
                        <span class="number">2</span>
                        <span class="title"> {{ __('panel.contract_template_text') }} </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(3)"
                    class="disabled {{ $currentStep == 3 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-1" href="#wizard1-h-1" aria-controls="wizard1-p-1">
                        <span class="number">3</span>
                        <span class="title"> {{ __('panel.contract_template_variables') }} </span>
                    </a>
                </li>
                <li role="tab" wire:click="directMoveToStep(4)"
                    class="disabled last {{ $currentStep == 4 ? 'current' : '' }}" aria-disabled="true">
                    <a id="wizard1-t-2" href="#wizard1-h-2" aria-controls="wizard1-p-2"><span class="number">4</span>
                        <span class="title">
                            {{ __('panel.contract_and_template_formatting') }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="mycontent">

            {{-- step 1 : بيانات نموذج الوثيقة --}}
            <h3 id="wizard1-h-0" tabindex="-1" class="title {{ $currentStep == 1 ? 'current' : '' }} ">
                {{ __('panel.contract_template_data') }}
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 1 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 1 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 1 ? 'block' : 'none' }}">


                <form action="{{ route('admin.document_templates.store') }}" method="post">
                    @csrf



                    <div class="row">
                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="contract_template_name"> {{ __('panel.contract_template_name') }}
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-10 pt-3">
                            <input type="text" id="contract_template_name" wire:model="contract_template_name"
                                name="contract_template_name" value="{{ old('contract_template_name') }}"
                                class="form-control" placeholder="">
                            @error('contract_template_name')
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

                    <div class="row" wire:ignore.self>
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
                {{ __('panel.contract_template_text') }}
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 2 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 2 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 2 ? 'block' : 'none' }}">

                {{-- <textarea name="contract_template_text" wire:model="contract_template_text" rows="10" class="form-control summernote">{!! old('contract_template_text') !!}</textarea> --}}

                <div wire:ignore>
                    {{-- <textarea name="contract_template_text" id="ckEditor2" wire:model="contract_template_text" rows="10"
                        class="form-control">{{ $contract_template_text }}</textarea> --}}

                    <textarea name="contract_template_text" id="tinymceExample" rows="10" class="form-control"
                        wire:model.defer="contract_template_text" placeholder=""></textarea>
                    @error('tinymceExample')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @error('contract_template_text')
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
                                "advlist autolink link image lists charmap print preview hr anchor variablebreak spellchecker",
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
                                    @this.set('contract_template_text', editor.getContent());
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
                        <h4>{{ __('panel.contract_template_variables') }}</h4>
                    </div>
                    <div class="col-md-auto aos-init aos-animate" data-aos="fade-start">
                        <button wire:click="saveStepThreeDataUsingBtn" class="btn btn-primary">
                            {{ __('panel.contract_template_variables_save') }}
                        </button>
                    </div>
                </div>
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 3 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 3 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 3 ? 'block' : 'none' }}">

                <div class="row">
                    <div class="col-sm-12 col-md-2 pt-3">
                        <h4 class="mb-3">متغيرات العقد</h4>
                        <ul style="list-style: none;margin:0;padding:0;">
                            @foreach ($variables as $index => $variable)
                                <li class="w-100 mb-1 d-flex justify-content-between"
                                    style="background-color: {{ $currentVariableIndex == $index ? '#0162e8' : '#b9c2d8' }} ; border-width: 0;">
                                    <a class="d-block" wire:click="setActiveVariable({{ $index }})"
                                        href="#" style="padding: 9px 20px;line-height: 1.538;color:#fff;">
                                        {{ $variable['cv_name'] }} </a>

                                    <a href=""
                                        wire:click.prevent="removeVariable({{ $currentVariableIndex }})"
                                        class="d-block pt-2" style="padding: 9px 20px;line-height: 1.538;color:#fff;">
                                        <i
                                            class="fas fa-trash-alt {{ $currentVariableIndex == $index ? 'text-white' : 'text-danger' }}  me-3"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-between" style="">
                            <!-- Button to add a new section -->
                            <a wire:click.prevent="addVariable()" class="d-block pt-2" style="cursor: pointer;">
                                <i class="fas fa-plus-square text-primary me-3"></i> {{ __('panel.add_variable') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-10 pt-3">
                        @if (isset($variables[$currentVariableIndex]))
                            <div class="card">
                                <div class="card-header mb-0 pb-0">
                                    <h2> <i class="far fa-edit" style="color: #0162e8"></i>
                                        {{ __('panel.variable') }}
                                        {{ $currentVariableIndex + 1 }}</h2>
                                </div>
                                <div class="card-body mt-0 pt-0">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 pt-3">
                                            <label for="{{ $variables[$currentVariableIndex]['cv_name'] }}">
                                                {{ __('panel.cv_name') }}
                                            </label>

                                            <input type="text" class="form-control"
                                                id="variables.{{ $index }}.cv_name"
                                                wire:model.defer="variables.{{ $currentVariableIndex }}.cv_name">

                                            @error('variables.' . $currentVariableIndex . '.cv_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div class="col-sm-12 col-md-8 pt-3">
                                            <label for="{{ $variables[$currentVariableIndex]['cv_question'] }}">
                                                {{ __('panel.cv_question') }}
                                            </label>

                                            <input type="text" class="form-control"
                                                id="{{ $variables[$currentVariableIndex]['cv_question'] }}"
                                                wire:model.defer="variables.{{ $currentVariableIndex }}.cv_question">

                                            @error('variables.' . $currentVariableIndex . '.cv_question')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 pt-3">
                                            <label for="{{ $variables[$currentVariableIndex]['cv_type'] }}">
                                                {{ __('panel.cv_type') }}
                                            </label>
                                            <select name="pv_type" class="form-control"
                                                id="variables.{{ $index }}.cv_type"
                                                wire:model.defer="variables.{{ $currentVariableIndex }}.cv_type">
                                                <option value="0"
                                                    {{ old('cv_type') == '0' ? 'selected' : null }}>
                                                    {{ __('panel.cv_type_text') }}
                                                </option>
                                                <option value="1"
                                                    {{ old('pv_type') == '1' ? 'selected' : null }}>
                                                    {{ __('panel.cv_type_number') }}
                                                </option>
                                            </select>
                                            @error('variables.' . $currentVariableIndex . '.cv_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div class="col-sm-12 col-md-6 pt-3">
                                            <label for="{{ $variables[$currentVariableIndex]['cv_required'] }}">
                                                {{ __('panel.cv_required') }}
                                            </label>
                                            <select name="pv_type" class="form-control"
                                                id="variables.{{ $index }}.cv_required"
                                                wire:model.defer="variables.{{ $currentVariableIndex }}.cv_required">
                                                <option value="1"
                                                    {{ old('cv_required') == '1' ? 'selected' : null }}>
                                                    {{ __('panel.yes') }}
                                                </option>
                                                <option value="0"
                                                    {{ old('cv_required') == '0' ? 'selected' : null }}>
                                                    {{ __('panel.no') }}
                                                </option>
                                            </select>
                                            @error('variables.' . $currentVariableIndex . '.cv_required')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 pt-3">
                                            <label for="{{ $variables[$currentVariableIndex]['cv_details'] }}">
                                                {{ __('panel.cv_details') }}
                                            </label>
                                            <textarea name="variables.{{ $index }}.cv_details" id="variables.{{ $index }}.cv_details"
                                                rows="10" class="form-control" wire:model.defer="variables.{{ $currentVariableIndex }}.cv_details">
                                                {!! old('pv_details') !!}
                                            </textarea>
                                            @error('variables.' . $currentVariableIndex . '.cv_details')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                {{ __('panel.contract_and_template_formatting') }}
            </h3>
            <section id="wizard1-p-3" role="tabpanel" aria-labelledby="wizard1-h-3"
                class="body {{ $currentStep == 4 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 4 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 4 ? 'block' : 'none' }}">

                <div class="row">
                    <div class="col-sm-12 col-md-4 pt-3">
                        <label for="{{ $variables[$currentVariableIndex]['cv_name'] }}">
                            {{ __('panel.cv_name') }}
                        </label>
                        <select name="cv_name" class="form-control">
                            <option value="" selected>-- {{ __('panel.select_variable') }} --</option>
                            @if ($contractTemplate)
                                @if ($contractTemplate->contractVariables->isNotEmpty())
                                    @foreach ($contractTemplate->contractVariables as $variable)
                                        <option value="{{ $variable->id }}">{{ $variable->cv_name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">No variables available</option>
                                @endif
                            @else
                                <p>No document template found.</p>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-8 pt-3" wire:ignore>
                        <textarea name="contract_template_text" id="tinymceEditor" class="form-control">{{ $contract_template_text }}</textarea>
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
                            "advlist autolink link image lists charmap print preview hr anchor variablebreak spellchecker",
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
                            document.querySelector('select[name="cv_name"]').addEventListener('change',
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
                                @this.set('contract_template_text', editor.getContent());
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
                        {{-- Next --}}
                        @if ($currentStep == 1)
                            {{ __('panel.contract_template_text') }} >>
                        @else
                            @if ($currentStep == 2)
                                {{ __('panel.contract_template_variables') }} >>
                            @else
                                {{ __('panel.contract_and_template_formatting') }} >>
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
