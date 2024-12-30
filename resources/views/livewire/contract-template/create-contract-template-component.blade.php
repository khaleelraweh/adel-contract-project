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
                {{ __('panel.document_template_data') }}
            </h3>

            <section id="wizard1-p-0" role="tabpanel" aria-labelledby="wizard1-h-0"
                class="body {{ $currentStep == 1 ? 'current' : '' }}  step"
                aria-hidden="{{ $currentStep == 1 ? 'false' : 'true' }}"
                style="display: {{ $currentStep == 1 ? 'block' : 'none' }}">

                <div class="row">
                    <div class="col-sm-12 col-md-2 pt-3">
                        <label for="name"> {{ __('panel.document_template_name') }}
                        </label>
                    </div>
                    <div class="col-sm-12 col-md-10 pt-3">
                        <input type="text" id="name" wire:model="name" name="name"
                            value="{{ old('name') }}" class="form-control" placeholder="">
                        @error('name')
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
                            <input type="radio" class="form-check-input" name="status" wire:model.defer="status"
                                id="status_active" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">
                                {{ __('panel.status_active') }}
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="status" wire:model.defer="status"
                                id="status_inactive" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">
                                {{ __('panel.status_inactive') }}
                            </label>
                        </div>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
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
                    <textarea name="text" id="ckEditor2" wire:model="text" rows="10" class="form-control">{{ $text }}</textarea>
                </div>

                @error('text')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let editorInstance2;

                        ClassicEditor
                            .create(document.querySelector('#ckEditor2'), {
                                language: 'ar', // Example setting for Arabic language
                                // Other editor configurations
                            })
                            .then(editor => {
                                editorInstance2 = editor;

                                // Set the initial text from Livewire
                                @this.on('updateContractTemplateText', (text) => {
                                    editorInstance2.setData(text);
                                });

                                // Sync CKEditor data with Livewire
                                editor.model.document.on('change:data', () => {
                                    @this.set('text', editorInstance2.getData());
                                });
                            })
                            .catch(error => {
                                console.error('Error initializing CKEditor:', error);
                            });
                    });

                    Livewire.on('updateContractTemplateText', text => {
                        if (editorInstance2) {
                            editorInstance2.setData(text);
                        }
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
                    <div class="col-sm-12 col-md-12 pt-3">
                        @foreach ($pages[$currentPageIndex]['groups'] as $groupIndex => $group)
                            @if ($groupIndex == $activeGroupIndex)
                                @foreach ($pages[$currentPageIndex]['groups'][$activeGroupIndex]['variables'] as $variableIndex => $variable)
                                    <div class="card">
                                        <div class="card-header mb-0">
                                            <div class="input-group mb-0" style="background: transparent;">
                                                <div class="d-flex align-items-center">
                                                    <h3 class="mb-0 " style="border:none;background:transparent">
                                                        <span>{{ __('panel.variable') }}</span>
                                                        <span><small>{{ $variableIndex + 1 }}</small>
                                                        </span>
                                                    </h3>
                                                    <a class="d-block mx-2"
                                                        style="background: none;border:none;cursor: pointer;"
                                                        wire:click.prevent="removeVariable({{ $currentPageIndex }}, {{ $groupIndex }}, {{ $variableIndex }})">
                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body mt-0">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="pv_name">{{ __('panel.pv_name') }}</label>
                                                        <input type="text" class="form-control"
                                                            wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_name">
                                                        @error('pages.' . $currentPageIndex . '.groups.' . $groupIndex .
                                                            '.variables.' . $variableIndex . '.pv_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="pv_question">{{ __('panel.pv_question') }}</label>
                                                        <input type="text" class="form-control"
                                                            wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_question">
                                                        @error('pages.' . $currentPageIndex . '.groups.' . $groupIndex .
                                                            '.variables.' . $variableIndex . '.pv_question')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 pt-3">
                                                    <label for="pv_type">{{ __('panel.pv_type') }}</label>
                                                    <select name="pv_type" class="form-control"
                                                        wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_type">
                                                        <option value="0"
                                                            {{ old('pv_type') == '0' ? 'selected' : null }}>
                                                            {{ __('panel.pv_type_text') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ old('pv_type') == '1' ? 'selected' : null }}>
                                                            {{ __('panel.pv_type_number') }}
                                                        </option>
                                                    </select>
                                                    @error('pages.' . $currentPageIndex . '.groups.' . $groupIndex .
                                                        '.variables.' . $variableIndex . '.pv_type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                                <div class="col-sm-12 col-md-6 pt-3">
                                                    <label for="pv_required">{{ __('panel.pv_required') }}</label>
                                                    <select name="pv_required" class="form-control"
                                                        wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_required">
                                                        <option value="1"
                                                            {{ old('pv_required') == '1' ? 'selected' : null }}>
                                                            {{ __('panel.yes') }}
                                                        </option>
                                                        <option value="0"
                                                            {{ old('pv_required') == '0' ? 'selected' : null }}>
                                                            {{ __('panel.no') }}
                                                        </option>
                                                    </select>
                                                    @error('pages.' . $currentPageIndex . '.groups.' . $groupIndex .
                                                        '.variables.' . $variableIndex . '.pv_required')
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
                                                        wire:model.defer="pages.{{ $currentPageIndex }}.groups.{{ $groupIndex }}.variables.{{ $variableIndex }}.pv_details">
                                                                {!! old('pv_details') !!}
                                                            </textarea>
                                                    @error('pages.' . $currentPageIndex . '.groups.' . $groupIndex .
                                                        '.variables.' . $variableIndex . '.pv_details')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach

                                <div class="row align-items-end mb-4 mb-md-0 pt-4">
                                    <div class="col-md mb-4 mb-md-0">
                                        <a href=""
                                            wire:click.prevent="addVariable({{ $currentPageIndex }}, {{ $groupIndex }})">
                                            <i class="fas fa-plus-circle me-2"></i>
                                            <span>
                                                {{ __('panel.add_variable') }}
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-md-auto aos-init aos-animate" data-aos="fade-start">

                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- step 4 :   تنسيق الوثيقة والمستند  --}}
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
                        {{-- <select name="pv_name" class="form-control" wire:model="selectedVariable"> --}}
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
                        <textarea name="text" id="khaleel3" class="form-control">{{ $text }}</textarea>
                    </div>
                </div>


            </section>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let editorInstance;

                    ClassicEditor
                        .create(document.querySelector('#khaleel3'), {
                            language: 'ar', // Example setting
                            // Other editor configurations
                        })
                        .then(editor => {
                            editorInstance = editor;

                            // Set the initial text from Livewire
                            @this.on('updateContractTemplateText', (text) => {
                                editorInstance.setData(text);
                            });

                            // Handle select changes
                            document.querySelector('select[name="pv_name"]').addEventListener('change', function() {
                                const selectedValue = this.value;
                                const selectedText = this.options[this.selectedIndex].text;

                                if (selectedValue && editorInstance) {
                                    editorInstance.model.change(writer => {
                                        writer.insertText("{!-" + selectedValue + '-' + selectedText +
                                            "!}",
                                            editorInstance.model.document.selection
                                            .getFirstPosition());
                                    });
                                }
                            });

                            // Sync CKEditor data with Livewire
                            editor.model.document.on('change:data', () => {
                                @this.set('text', editorInstance.getData());
                            });
                        })
                        .catch(error => {
                            console.error('Error initializing CKEditor:', error);
                        });
                });

                Livewire.on('updateContractTemplateText', text => {
                    if (editorInstance) {
                        editorInstance.setData(text);
                    }
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
